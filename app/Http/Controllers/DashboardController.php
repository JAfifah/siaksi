<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        $activities = Activity::with(['user', 'document'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('activities'));
    }
}