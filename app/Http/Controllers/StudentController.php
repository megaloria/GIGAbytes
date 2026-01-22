<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Submission;
use App\Models\Badge;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user();

        $stats = [
            'completed_tasks' => $student->submissions()->where('status', 'graded')->count(),
            'pending_tasks' => $student->submissions()->where('status', 'pending')->count(),
            'total_xp' => $student->xp_points,
            'level' => $student->level,
            'badges_count' => $student->badges()->count(),
        ];

        $recentSubmissions = $student->submissions()
            ->with('task')
            ->latest()
            ->take(5)
            ->get();

        $availableTasks = Task::whereDoesntHave('submissions', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })->where('due_date', '>=', now())->take(5)->get();

        return view('student.dashboard', compact('stats', 'recentSubmissions', 'availableTasks'));
    }

    public function tasks()
    {
        $student = auth()->user();

        $tasks = Task::with(['submissions' => function ($query) use ($student) {
            $query->where('student_id', $student->id);
        }])->where('due_date', '>=', now())->latest()->paginate(10);

        return view('student.tasks', compact('tasks'));
    }

    public function showTask(Task $task)
    {
        $student = auth()->user();
        $submission = $task->submissions()->where('student_id', $student->id)->first();

        return view('student.task-show', compact('task', 'submission'));
    }

    public function submitTask(Request $request, Task $task)
    {
        $student = auth()->user();

        // Check if already submitted
        if ($task->submissions()->where('student_id', $student->id)->exists()) {
            return back()->with('error', 'You have already submitted this task.');
        }

        if ($task->type === 'speaking') {
            $request->validate([
                'video_link' => 'required|url',
            ]);

            Submission::create([
                'task_id' => $task->id,
                'student_id' => $student->id,
                'video_link' => $request->video_link,
            ]);
        } else {
            $request->validate([
                'content' => 'required|string|min:50',
            ]);

            Submission::create([
                'task_id' => $task->id,
                'student_id' => $student->id,
                'content' => $request->content,
            ]);
        }

        // Check and award badges
        $this->checkBadges($student);

        return redirect()->route('student.submissions')->with('success', 'Task submitted successfully!');
    }

    public function submissions()
    {
        $submissions = auth()->user()->submissions()
            ->with('task')
            ->latest()
            ->paginate(10);

        return view('student.submissions', compact('submissions'));
    }

    public function progress()
    {
        $student = auth()->user();

        $stats = [
            'xp_points' => $student->xp_points,
            'level' => $student->level,
            'xp_progress' => $student->xpProgress(),
            'xp_to_next' => $student->xpToNextLevel(),
            'speaking_completed' => $student->submissions()
                ->whereHas('task', fn($q) => $q->where('type', 'speaking'))
                ->where('status', 'graded')->count(),
            'writing_completed' => $student->submissions()
                ->whereHas('task', fn($q) => $q->where('type', 'writing'))
                ->where('status', 'graded')->count(),
        ];

        $badges = Badge::all();
        $earnedBadges = $student->badges()->pluck('badges.id')->toArray();

        return view('student.progress', compact('stats', 'badges', 'earnedBadges'));
    }

    private function checkBadges($student)
    {
        $badges = Badge::all();

        foreach ($badges as $badge) {
            if ($student->badges()->where('badge_id', $badge->id)->exists()) {
                continue;
            }

            $earned = false;

            switch ($badge->criteria_type) {
                case 'speaking_count':
                    $count = $student->submissions()
                        ->whereHas('task', fn($q) => $q->where('type', 'speaking'))
                        ->where('status', 'graded')->count();
                    $earned = $count >= $badge->criteria_value;
                    break;

                case 'writing_count':
                    $count = $student->submissions()
                        ->whereHas('task', fn($q) => $q->where('type', 'writing'))
                        ->where('status', 'graded')->count();
                    $earned = $count >= $badge->criteria_value;
                    break;

                case 'level':
                    $earned = $student->level >= $badge->criteria_value;
                    break;
            }

            if ($earned) {
                $student->badges()->attach($badge->id, ['earned_at' => now()]);
            }
        }
    }
}
