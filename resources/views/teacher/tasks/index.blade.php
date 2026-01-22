@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
<div class="card card-dashboard">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">My Tasks</h5>
        <a href="{{ route('teacher.tasks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Create Task
        </a>
    </div>
    <div class="card-body">
        @if($tasks->count() > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Points</th>
                    <th>Due Date</th>
                    <th>Submissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>
                        <span class="badge bg-{{ $task->type === 'speaking' ? 'info' : 'success' }}">
                            <i class="bi bi-{{ $task->type === 'speaking' ? 'mic' : 'pencil' }} me-1"></i>
                            {{ ucfirst($task->type) }}
                        </span>
                    </td>
                    <td>{{ $task->points }} pts</td>
                    <td>
                        @if($task->isOverdue())
                            <span class="text-danger">{{ $task->due_date->format('M d, Y') }}</span>
                        @else
                            {{ $task->due_date->format('M d, Y') }}
                        @endif
                    </td>
                    <td>{{ $task->submissions->count() }}</td>
                    <td>
                        <a href="{{ route('teacher.tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('teacher.tasks.delete', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure? This will also delete all submissions.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $tasks->links() }}
        </div>
        @else
            <p class="text-muted text-center mb-0">No tasks yet. Create your first task!</p>
        @endif
    </div>
</div>
@endsection
