@extends('layouts.app')

@section('title', 'My Submissions')

@section('content')
<div class="card card-dashboard">
    <div class="card-header">
        <h5 class="mb-0">My Submissions</h5>
    </div>
    <div class="card-body">
        @if($submissions->count() > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Type</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Score</th>
                    <th>XP Earned</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                <tr>
                    <td>
                        <a href="{{ route('student.tasks.show', $submission->task) }}">
                            {{ $submission->task->title }}
                        </a>
                    </td>
                    <td>
                        <span class="badge bg-{{ $submission->task->type === 'speaking' ? 'info' : 'success' }}">
                            {{ ucfirst($submission->task->type) }}
                        </span>
                    </td>
                    <td>{{ $submission->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($submission->isGraded())
                            <span class="badge bg-success">Graded</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($submission->isGraded())
                            <strong>{{ $submission->score }}/100</strong>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($submission->isGraded())
                            <span class="text-success">
                                <i class="bi bi-lightning-fill"></i> {{ $submission->calculateXp() }}
                            </span>
                        @else
                            -
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
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-3 mb-0">You haven't submitted any tasks yet.</p>
                <a href="{{ route('student.tasks') }}" class="btn btn-primary mt-3">Browse Tasks</a>
            </div>
        @endif
    </div>
</div>
@endsection
