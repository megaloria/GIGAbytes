<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $topStudents = User::where('role', 'student')
            ->orderBy('xp_points', 'desc')
            ->take(20)
            ->get();

        return view('leaderboard', compact('topStudents'));
    }
}
