@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')
<div class="card card-dashboard">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Top Students</h5>
    </div>
    <div class="card-body">
        @if($topStudents->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px;">Rank</th>
                        <th>Student</th>
                        <th class="text-center">Level</th>
                        <th class="text-center">XP</th>
                        <th class="text-center">Badges</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topStudents as $index => $student)
                    <tr class="leaderboard-item {{ auth()->id() === $student->id ? 'table-primary' : '' }}">
                        <td>
                            @if($index === 0)
                                <span class="fs-4">🥇</span>
                            @elseif($index === 1)
                                <span class="fs-4">🥈</span>
                            @elseif($index === 2)
                                <span class="fs-4">🥉</span>
                            @else
                                <span class="badge bg-secondary">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $student->name }}</strong>
                                    @if(auth()->id() === $student->id)
                                        <span class="badge bg-primary ms-2">You</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-level px-3 py-2">
                                <i class="bi bi-star-fill me-1"></i> {{ $student->level }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-xp px-3 py-2">
                                <i class="bi bi-lightning-fill me-1"></i> {{ number_format($student->xp_points) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info px-3 py-2">
                                <i class="bi bi-award me-1"></i> {{ $student->badges()->count() }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-trophy fs-1 text-muted"></i>
                <p class="text-muted mt-3 mb-0">No students on the leaderboard yet. Start completing tasks to earn XP!</p>
            </div>
        @endif
    </div>
</div>
@endsection
