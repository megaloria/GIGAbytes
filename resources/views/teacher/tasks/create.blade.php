@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-dashboard">
            <div class="card-header">
                <h5 class="mb-0">Create New Task</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description / Instructions</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="type" class="form-label">Task Type</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="speaking" {{ old('type') === 'speaking' ? 'selected' : '' }}>Speaking</option>
                                    <option value="writing" {{ old('type') === 'writing' ? 'selected' : '' }}>Writing</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="points" class="form-label">Points</label>
                                <input type="number" class="form-control @error('points') is-invalid @enderror" id="points" name="points" value="{{ old('points', 10) }}" min="1" max="100" required>
                                @error('points')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info" id="typeHint" style="display: none;">
                        <i class="bi bi-info-circle me-2"></i>
                        <span id="typeHintText"></span>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Create Task
                        </button>
                        <a href="{{ route('teacher.tasks.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    const hint = document.getElementById('typeHint');
    const hintText = document.getElementById('typeHintText');

    if (this.value === 'speaking') {
        hint.style.display = 'block';
        hintText.textContent = 'Students will submit a YouTube or video link for speaking tasks.';
    } else if (this.value === 'writing') {
        hint.style.display = 'block';
        hintText.textContent = 'Students will write and submit text content for writing tasks.';
    } else {
        hint.style.display = 'none';
    }
});
</script>
@endsection
