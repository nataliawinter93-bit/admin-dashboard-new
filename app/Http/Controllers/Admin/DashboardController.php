<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }
    public function analytics()
{
    $logsByDate = \App\Models\ActivityLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $dates = $logsByDate->pluck('date');
    $counts = $logsByDate->pluck('count');

    return view('admin.dashboard.index', compact('dates', 'counts'));
}


}
