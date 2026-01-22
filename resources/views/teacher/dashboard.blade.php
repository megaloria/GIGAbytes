@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-dashboard bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Tasks</h6>
                        <h2 class="mb-0">{{ $stats['total_tasks'] }}</h2>
                    </div>
                    <i class="bi bi-list-task fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Speaking Tasks</h6>
                        <h2 class="mb-0">{{ $stats['speaking_tasks'] }}</h2>
                    </div>
                    <i class="bi bi-mic fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Writing Tasks</h6>
                        <h2 class="mb-0">{{ $stats['writing_tasks'] }}</h2>
                    </div>
                    <i class="bi bi-pencil fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dashboard bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Pending Grading</h6>
                        <h2 class="mb-0">{{ $stats['pending_submissions'] }}</h2>
                    </div>
                    <i class="bi bi-hourglass-split fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('teacher.tasks.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i> Create New Task
                    </a>
                    <a href="{{ route('teacher.submissions') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-check me-2"></i> View All Submissions
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pending Submissions</h5>
                <a href="{{ route('teacher.submissions') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentSubmissions->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($recentSubmissions as $submission)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $submission->student->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $submission->task->title }}</small>
                            </div>
                            <a href="{{ route('teacher.submissions.grade', $submission) }}" class="btn btn-sm btn-outline-primary">Grade</a>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">No pending submissions.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
