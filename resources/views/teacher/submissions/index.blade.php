@extends('layouts.app')

@section('title', 'Submissions')

@section('content')
<div class="card card-dashboard">
    <div class="card-header">
        <h5 class="mb-0">Student Submissions</h5>
    </div>
    <div class="card-body">
        @if($submissions->count() > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Task</th>
                    <th>Type</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                <tr>
                    <td>{{ $submission->student->name }}</td>
                    <td>{{ $submission->task->title }}</td>
                    <td>
                        <span class="badge bg-{{ $submission->task->type === 'speaking' ? 'info' : 'success' }}">
                            {{ ucfirst($submission->task->type) }}
                        </span>
                    </td>
                    <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                    <td>
                        @if($submission->isPending())
                            <span class="badge bg-warning text-dark">Pending</span>
                        @else
                            <span class="badge bg-success">Graded</span>
                        @endif
                    </td>
                    <td>{{ $submission->score ?? '-' }}</td>
                    <td>
                        @if($submission->isPending())
                            <a href="{{ route('teacher.submissions.grade', $submission) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-check2-square me-1"></i> Grade
                            </a>
                        @else
                            <a href="{{ route('teacher.submissions.grade', $submission) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye me-1"></i> View
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $submissions->links() }}
        </div>
        @else
            <p class="text-muted text-center mb-0">No submissions yet.</p>
        @endif
    </div>
</div>
@endsection
