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
            
            if ($user->role->name === 'Technician') {
                // For Technician: Show jobs assigned to them
                $stats = [
                    'todayJobs' => ServiceRequest::where('technician_id', $user->id)
                                               ->whereDate('created_at', today())
                                               ->count(),
                    'submittedJobs' => ServiceRequest::where('technician_id', $user->id)
                                                   ->where('status', 'assigned')
                                                   ->count(),
                    'inProgressJobs' => ServiceRequest::where('technician_id', $user->id)
                                                    ->whereIn('status', ['diagnosis', 'repairing'])
                                                    ->count(),
                    'completedJobs' => ServiceRequest::where('technician_id', $user->id)
                                                   ->where('status', 'completed')
                                                   ->whereDate('updated_at', today())
                                                   ->count(),
                ];
            } else {
                // For HelpDesk and Admin: Show all jobs completed today
                $stats = [
                    'todayJobs' => ServiceRequest::whereDate('created_at', today())->count(),
                    'submittedJobs' => ServiceRequest::where('status', 'submitted')->count(),
                    'inProgressJobs' => ServiceRequest::whereIn('status', ['diagnosis', 'repairing'])->count(),
                    'completedJobs' => ServiceRequest::where('status', 'completed')
                                                   ->whereDate('updated_at', today())
                                                   ->count(),
                ];
            }
        }

        return view('dashboard.welcome', $stats);
    }
}