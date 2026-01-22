<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $teacher = auth()->user();

        $stats = [
            'total_tasks' => $teacher->tasks()->count(),
            'speaking_tasks' => $teacher->tasks()->where('type', 'speaking')->count(),
            'writing_tasks' => $teacher->tasks()->where('type', 'writing')->count(),
            'pending_submissions' => Submission::whereIn('task_id', $teacher->tasks()->pluck('id'))
                ->where('status', 'pending')->count(),
        ];

        $recentSubmissions = Submission::whereIn('task_id', $teacher->tasks()->pluck('id'))
            ->with(['student', 'task'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact('stats', 'recentSubmissions'));
    }

    // Task CRUD
    public function tasks()
    {
        $tasks = auth()->user()->tasks()->latest()->paginate(10);
        return view('teacher.tasks.index', compact('tasks'));
    }

    public function createTask()
    {
        return view('teacher.tasks.create');
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:speaking,writing',
            'points' => 'required|integer|min:1|max:100',
            'due_date' => 'required|date|after:today',
        ]);

        auth()->user()->tasks()->create($request->all());

        return redirect()->route('teacher.tasks.index')->with('success', 'Task created successfully.');
    }

    public function editTask(Task $task)
    {
        $this->authorizeTask($task);
        return view('teacher.tasks.edit', compact('task'));
    }

    public function updateTask(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:speaking,writing',
            'points' => 'required|integer|min:1|max:100',
            'due_date' => 'required|date',
        ]);

        $task->update($request->all());

        return redirect()->route('teacher.tasks.index')->with('success', 'Task updated successfully.');
    }

    public function deleteTask(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();

        return redirect()->route('teacher.tasks.index')->with('success', 'Task deleted successfully.');
    }

    // Submissions & Grading
    public function submissions()
    {
        $submissions = Submission::whereIn('task_id', auth()->user()->tasks()->pluck('id'))
            ->with(['student', 'task'])
            ->latest()
            ->paginate(15);

        return view('teacher.submissions.index', compact('submissions'));
    }

    public function gradeSubmission(Submission $submission)
    {
        $this->authorizeSubmission($submission);
        return view('teacher.submissions.grade', compact('submission'));
    }

    public function storeGrade(Request $request, Submission $submission)
    {
        $this->authorizeSubmission($submission);

        $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'status' => 'graded',
        ]);

        // Award XP to student
        $xpEarned = $submission->calculateXp();
        $submission->student->addXp($xpEarned);

        return redirect()->route('teacher.submissions')->with('success', "Submission graded. Student earned {$xpEarned} XP.");
    }

    private function authorizeTask(Task $task)
    {
        if ($task->teacher_id !== auth()->id()) {
            abort(403);
        }
    }

    private function authorizeSubmission(Submission $submission)
    {
        if ($submission->task->teacher_id !== auth()->id()) {
            abort(403);
        }
    }
}
