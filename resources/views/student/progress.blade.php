@extends('layouts.app')

@section('title', 'My Progress')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card card-dashboard">
            <div class="card-body text-center py-4">
                <h1 class="display-1 text-primary mb-0">{{ $stats['level'] }}</h1>
                <p class="text-muted mb-3">Current Level</p>
                <div class="progress progress-xp mb-2">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $stats['xp_progress'] }}%">
                        {{ $stats['xp_progress'] }}%
                    </div>
                </div>
                <small class="text-muted">{{ $stats['xp_to_next'] }} XP to Level {{ $stats['level'] + 1 }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-dashboard h-100">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 border-end">
                        <h2 class="text-warning mb-0">{{ $stats['xp_points'] }}</h2>
                        <small class="text-muted">Total XP</small>
                    </div>
                    <div class="col-6">
                        <h2 class="text-info mb-0">{{ count($earnedBadges) }}</h2>
                        <small class="text-muted">Badges Earned</small>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6 border-end">
                        <h3 class="text-info mb-0">{{ $stats['speaking_completed'] }}</h3>
                        <small class="text-muted"><i class="bi bi-mic"></i> Speaking Completed</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-success mb-0">{{ $stats['writing_completed'] }}</h3>
                        <small class="text-muted"><i class="bi bi-pencil"></i> Writing Completed</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-dashboard">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-award me-2"></i>Badges</h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            @foreach($badges as $badge)
            @php
                $isEarned = in_array($badge->id, $earnedBadges);
            @endphp
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 {{ $isEarned ? 'border-success' : 'border-secondary opacity-50' }}">
                    <div class="card-body text-center">
                        <i class="bi {{ $badge->icon }} fs-1 {{ $isEarned ? 'text-warning' : 'text-muted' }}"></i>
                        <h6 class="mt-3 mb-1">{{ $badge->name }}</h6>
                        <small class="text-muted">{{ $badge->description }}</small>
                        @if($isEarned)
                            <div class="mt-2">
                                <span class="badge bg-success"><i class="bi bi-check"></i> Earned!</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
