@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-dashboard bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Level</h6>
                        <h2 class="mb-0">{{ $stats['level'] }}</h2>
                    </div>
                    <i class="bi bi-star-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total XP</h6>
                        <h2 class="mb-0">{{ $stats['total_xp'] }}</h2>
                    </div>
                    <i class="bi bi-lightning-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Completed</h6>
                        <h2 class="mb-0">{{ $stats['completed_tasks'] }}</h2>
                    </div>
                    <i class="bi bi-check-circle-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Badges</h6>
                        <h2 class="mb-0">{{ $stats['badges_count'] }}</h2>
                    </div>
                    <i class="bi bi-award-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- XP Progress -->
<div class="card card-dashboard mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Progress to Level {{ $stats['level'] + 1 }}</h6>
            <small class="text-muted">{{ auth()->user()->xpToNextLevel() }} XP needed</small>
        </div>
        <div class="progress progress-xp">
            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ auth()->user()->xpProgress() }}%">
                {{ auth()->user()->xpProgress() }}%
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Available Tasks</h5>
                <a href="{{ route('student.tasks') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @if($availableTasks->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($availableTasks as $task)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-{{ $task->type === 'speaking' ? 'info' : 'success' }} me-2">
                                    <i class="bi bi-{{ $task->type === 'speaking' ? 'mic' : 'pencil' }}"></i>
                                </span>
                                {{ $task->title }}
                                <br>
                                <small class="text-muted">Due: {{ $task->due_date->format('M d, Y') }} | {{ $task->points }} pts</small>
                            </div>
                            <a href="{{ route('student.tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">No tasks available right now.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Submissions</h5>
                <a href="{{ route('student.submissions') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentSubmissions->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($recentSubmissions as $submission)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                {{ $submission->task->title }}
                                <br>
                                <small class="text-muted">{{ $submission->created_at->diffForHumans() }}</small>
                            </div>
                            @if($submission->isGraded())
                                <span class="badge bg-success">{{ $submission->score }}/100</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">No submissions yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
