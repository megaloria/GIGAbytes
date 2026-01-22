@extends('layouts.app')

@section('title', 'Grade Submission')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-dashboard mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ $submission->task->title }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Task Type:</strong>
                    <span class="badge bg-{{ $submission->task->type === 'speaking' ? 'info' : 'success' }}">
                        {{ ucfirst($submission->task->type) }}
                    </span>
                </div>
                <div class="mb-3">
                    <strong>Task Description:</strong>
                    <p class="mb-0">{{ $submission->task->description }}</p>
                </div>
                <div class="mb-3">
                    <strong>Points:</strong> {{ $submission->task->points }} pts
                </div>
            </div>
        </div>

        <div class="card card-dashboard">
            <div class="card-header">
                <h5 class="mb-0">Student Submission</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Student:</strong> {{ $submission->student->name }}
                </div>
                <div class="mb-3">
                    <strong>Submitted:</strong> {{ $submission->created_at->format('M d, Y H:i') }}
                </div>

                @if($submission->task->type === 'speaking')
                    <div class="mb-3">
                        <strong>Video Link:</strong>
                        <a href="{{ $submission->video_link }}" target="_blank" class="d-block">
                            {{ $submission->video_link }}
                        </a>
                        @if(str_contains($submission->video_link, 'youtube') || str_contains($submission->video_link, 'youtu.be'))
                            @php
                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $submission->video_link, $matches);
                                $videoId = $matches[1] ?? null;
                            @endphp
                            @if($videoId)
                                <div class="ratio ratio-16x9 mt-3">
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                                </div>
                            @endif
                        @endif
                    </div>
                @else
                    <div class="mb-3">
                        <strong>Written Content:</strong>
                        <div class="border rounded p-3 bg-light mt-2">
                            {!! nl2br(e($submission->content)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-dashboard">
            <div class="card-header">
                <h5 class="mb-0">
                    @if($submission->isGraded())
                        Grade Details
                    @else
                        Grade Submission
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @if($submission->isGraded())
                    <div class="text-center mb-4">
                        <h1 class="display-4 text-primary">{{ $submission->score }}/100</h1>
                        <p class="text-muted">Score</p>
                    </div>
                    @if($submission->feedback)
                        <div class="mb-3">
                            <strong>Feedback:</strong>
                            <p class="mb-0">{{ $submission->feedback }}</p>
                        </div>
                    @endif
                    <div class="alert alert-success">
                        <i class="bi bi-lightning-fill me-1"></i>
                        Student earned <strong>{{ $submission->calculateXp() }} XP</strong> from this submission.
                    </div>
                @else
                    <form action="{{ route('teacher.submissions.store-grade', $submission) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="score" class="form-label">Score (0-100)</label>
                            <input type="number" class="form-control form-control-lg @error('score') is-invalid @enderror" id="score" name="score" min="0" max="100" value="{{ old('score') }}" required>
                            @error('score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="feedback" class="form-label">Feedback (Optional)</label>
                            <textarea class="form-control @error('feedback') is-invalid @enderror" id="feedback" name="feedback" rows="4">{{ old('feedback') }}</textarea>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <i class="bi bi-info-circle me-1"></i>
                                XP awarded = Task Points ({{ $submission->task->points }}) x Score%
                            </small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Submit Grade
                            </button>
                        </div>
                    </form>
                @endif

                <hr>
                <a href="{{ route('teacher.submissions') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-left me-1"></i> Back to Submissions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
