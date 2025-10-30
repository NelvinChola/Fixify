<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class DashboardController extends Controller
{
    public function welcome()
    {
        $user = auth()->user();
        $stats = [];

        // Only calculate stats for staff members
        if (in_array($user->role->name, ['HelpDesk', 'Admin', 'Technician'])) {
            $stats = [
                'todayJobs' => ServiceRequest::whereDate('created_at', today())->count(),
                'submittedJobs' => ServiceRequest::where('status', 'submitted')->count(),
                'inProgressJobs' => ServiceRequest::whereIn('status', ['assigned', 'diagnosis', 'repairing'])->count(),
                'completedJobs' => ServiceRequest::where('status', 'completed')->count(),
            ];
        }

        return view('dashboard.welcome', $stats);
    }
}