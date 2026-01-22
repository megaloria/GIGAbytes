@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-dashboard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-{{ $task->type === 'speaking' ? 'info' : 'success' }} me-2">
                        <i class="bi bi-{{ $task->type === 'speaking' ? 'mic' : 'pencil' }} me-1"></i>
                        {{ ucfirst($task->type) }} Task
                    </span>
                    <span class="badge bg-secondary">{{ $task->points }} pts</span>
                </div>
                <small class="text-muted">Due: {{ $task->due_date->format('M d, Y') }}</small>
            </div>
            <div class="card-body">
                <h4>{{ $task->title }}</h4>
                <hr>
                <h6>Instructions:</h6>
                <p>{!! nl2br(e($task->description)) !!}</p>
            </div>
        </div>

        @if(!$submission)
        <div class="card card-dashboard mt-4">
            <div class="card-header">
                <h5 class="mb-0">Submit Your Work</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('student.tasks.submit', $task) }}" method="POST">
                    @csrf

                    @if($task->type === 'speaking')
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Upload your video to YouTube (or similar platform) and paste the link below.
                        </div>
                        <div class="mb-3">
                            <label for="video_link" class="form-label">Video Link</label>
                            <input type="url" class="form-control @error('video_link') is-invalid @enderror" id="video_link" name="video_link" value="{{ old('video_link') }}" placeholder="https://www.youtube.com/watch?v=..." required>
                            @error('video_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Write your response below. Minimum 50 characters required.
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Your Response</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted"><span id="charCount">0</span> characters</small>
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Submit
                        </button>
                        <a href="{{ route('student.tasks') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        @if($submission)
        <div class="card card-dashboard">
            <div class="card-header">
                <h5 class="mb-0">Your Submission</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status:</strong>
                    @if($submission->isGraded())
                        <span class="badge bg-success">Graded</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending Review</span>
                    @endif
                </div>

                <div class="mb-3">
                    <strong>Submitted:</strong>
                    <br>{{ $submission->created_at->format('M d, Y H:i') }}
                </div>

                @if($submission->isGraded())
                    <div class="text-center mb-3">
                        <h1 class="display-4 text-primary">{{ $submission->score }}/100</h1>
                        <p class="text-muted">Your Score</p>
                    </div>

                    <div class="alert alert-success">
                        <i class="bi bi-lightning-fill me-1"></i>
                        You earned <strong>{{ $submission->calculateXp() }} XP</strong>!
                    </div>

                    @if($submission->feedback)
                        <div class="mb-3">
                            <strong>Teacher Feedback:</strong>
                            <p class="mb-0 mt-2">{{ $submission->feedback }}</p>
                        </div>
                    @endif
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-hourglass-split me-1"></i>
                        Your submission is awaiting review by the teacher.
                    </div>
                @endif
            </div>
        </div>
        @else
        <div class="card card-dashboard">
            <div class="card-body">
                <h6><i class="bi bi-lightbulb me-2"></i>Tips</h6>
                <ul class="mb-0">
                    @if($task->type === 'speaking')
                        <li>Record a clear video with good lighting</li>
                        <li>Speak clearly and at a natural pace</li>
                        <li>Make sure your video is set to public or unlisted</li>
                    @else
                        <li>Read the instructions carefully</li>
                        <li>Plan your response before writing</li>
                        <li>Check your grammar and spelling</li>
                    @endif
                </ul>
            </div>
        </div>
        @endif

        <div class="card card-dashboard mt-3">
            <div class="card-body text-center">
                <a href="{{ route('student.tasks') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-left me-1"></i> Back to Tasks
                </a>
            </div>
        </div>
    </div>
</div>

@if($task->type === 'writing' && !$submission)
<script>
document.getElementById('content').addEventListener('input', function() {
    document.getElementById('charCount').textContent = this.value.length;
});
</script>
@endif
@endsection
