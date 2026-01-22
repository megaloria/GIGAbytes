@extends('layouts.app')

@section('title', 'Available Tasks')

@section('content')
<div class="row g-4">
    @forelse($tasks as $task)
    @php
        $submission = $task->submissions->first();
    @endphp
    <div class="col-md-6 col-lg-4">
        <div class="card card-dashboard task-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="badge bg-{{ $task->type === 'speaking' ? 'info' : 'success' }}">
                    <i class="bi bi-{{ $task->type === 'speaking' ? 'mic' : 'pencil' }} me-1"></i>
                    {{ ucfirst($task->type) }}
                </span>
                <span class="badge bg-secondary">{{ $task->points }} pts</span>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $task->title }}</h5>
                <p class="card-text text-muted">{{ Str::limit($task->description, 100) }}</p>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i>
                        Due: {{ $task->due_date->format('M d, Y') }}
                    </small>
                    @if($submission)
                        @if($submission->isGraded())
                            <span class="badge bg-success">Graded: {{ $submission->score }}/100</span>
                        @else
                            <span class="badge bg-warning text-dark">Submitted</span>
                        @endif
                    @else
                        <a href="{{ route('student.tasks.show', $task) }}" class="btn btn-sm btn-primary">
                            Start Task
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card card-dashboard">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-3 mb-0">No tasks available at the moment.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $tasks->links() }}
</div>
@endsection
