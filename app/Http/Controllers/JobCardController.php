<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class JobCardController extends Controller
{
public function index(Request $request)
{
    $user = Auth::user();
    
    // Get user role
    $userRole = $user->role;
    $roleName = is_object($userRole) ? strtolower($userRole->name) : strtolower($userRole);
    
    // Get filter from request
    $filter = $request->query('filter', 'all');
    
    if ($roleName === 'technician') {
        // Technician can only see job cards assigned to them
        $query = ServiceRequest::with(['device', 'customer', 'technician'])
            ->where('technician_id', $user->id);
            
        // Apply status filter if not 'all'
        if ($filter !== 'all') {
            $query->where('status', $filter);
        }
            
        $requests = $query->latest()->paginate(12);
    } else {
        // Helpdesk and Admin can see all job cards
        $query = ServiceRequest::with(['device', 'customer', 'technician']);
            
        // Apply status filter if not 'all'
        if ($filter !== 'all') {
            $query->where('status', $filter);
        }
            
        $requests = $query->latest()->paginate(12);
    }

    // Calculate status counts based on the filtered results
    $submittedCount = $this->getStatusCount('submitted', $user, $roleName);
    $assessedCount = $this->getStatusCount('assessed', $user, $roleName);
    $assignedCount = $this->getStatusCount('assigned', $user, $roleName);
    $diagnosisCount = $this->getStatusCount('diagnosis', $user, $roleName);
    $repairingCount = $this->getStatusCount('repairing', $user, $roleName);
    $completedCount = $this->getStatusCount('completed', $user, $roleName);
    $unsuccessfulCount = $this->getStatusCount('unsuccessful', $user, $roleName);
    $sentBackCount = $this->getStatusCount('sent_back', $user, $roleName);
    $archivedCount = $this->getStatusCount('archived', $user, $roleName);

    return view('JobCard.index', compact(
        'requests', 
        'filter',
        'submittedCount',
        'assessedCount',
        'assignedCount', 
        'diagnosisCount',
        'repairingCount',
        'completedCount',
        'unsuccessfulCount',
        'sentBackCount',
        'archivedCount'
    ));
}

    /**
     * Helper method to get count for a specific status based on user role
     */
    private function getStatusCount($status, $user, $roleName)
    {
        if ($roleName === 'technician') {
            return ServiceRequest::where('status', $status)
                ->where('technician_id', $user->id)
                ->count();
        } else {
            return ServiceRequest::where('status', $status)->count();
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $userRole = $user->role;
        $roleName = is_object($userRole) ? strtolower($userRole->name) : strtolower($userRole);
        
        $request = ServiceRequest::with(['device', 'customer', 'technician'])->findOrFail($id);

        //dd($request->unsucessful_notes);

        
if ($roleName == 'technician' && $request->technician_id != $user->id) {
    abort(403, 'You are not authorized to view this job card.');
}

        // Get all technicians (you can filter by role)
        $technicians = User::whereHas('role', function ($q) {
            $q->where('name', 'technician');
        })->get();

        return view('JobCard.show', compact('request', 'technicians'));
    }

public function updateStatus(Request $request, $id)
{
    $user = Auth::user();
    $userRole = $user->role;
    $roleName = is_object($userRole) ? strtolower($userRole->name) : strtolower($userRole);
    
    $jobCard = ServiceRequest::findOrFail($id);

    // If user is technician, check if they are assigned to this job card
    if ($roleName === 'technician' && $jobCard->technician_id !== $user->id) {
        abort(403, 'You are not authorized to update this job card.');
    }

    // Debug: Check what's coming in the request
    \Log::info('Update Status Request Data:', $request->all());
    
    $request->validate([
        'status' => 'required|string|in:submitted,assessed,assigned,diagnosis,repairing,completed,unsuccessful,sent_back',
        'assessment_notes' => 'nullable|string|min:10|max:1000',
        'unsuccessful_notes' => 'nullable|string|min:10|max:1000'
    ]);

    $updateData = ['status' => $request->status];
    
    // Add assessment notes and timestamp if provided
    if ($request->status == 'assessed' && $request->filled('assessment_notes')) {
        $updateData['assessment_notes'] = $request->assessment_notes;
        $updateData['assessed_at'] = now();
    }
    
    // Add unsuccessful notes and timestamp if provided
    if ($request->status == 'unsuccessful') {
        if ($request->filled('unsuccessful_notes')) {
            $updateData['unsuccessful_notes'] = $request->unsuccessful_notes;
            $updateData['unsuccessful_at'] = now();
        } else {
            // If status is unsuccessful but no notes provided, return error
            return redirect()->back()->with('error', 'Please provide notes explaining why the repair was unsuccessful.');
        }
    }

    // Handle completion logic
    if ($request->status === 'completed') {
        $additionalFees = $jobCard->additional_fees ?? 0;
        
        if ($additionalFees > 0 && empty($jobCard->additional_fees_notes)) {
            return redirect()->back()->with('error', 'Please provide explanation for additional fees before completing the job.');
        }

        try {
            $jobCard = $this->handleJobCompletion($jobCard);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    // Debug before update
    \Log::info('Data to be updated:', $updateData);
    
    // Update the job card
    $jobCard->update($updateData);
    
    // Debug after update
    $updatedJobCard = ServiceRequest::find($id);
    \Log::info('After update - unsuccessful_notes:', ['notes' => $updatedJobCard->unsuccessful_notes]);
    

    
// NEW: Notify all involved parties
$this->notifyStatusUpdate($jobCard, $request->status,auth()->id());


    return redirect()->back()->with('success', 'Status updated successfully.');
}
    public function assignTechnician(Request $request, $id)
    {
        $user = Auth::user();
        $userRole = $user->role;
        $roleName = is_object($userRole) ? strtolower($userRole->name) : strtolower($userRole);
        
        // Only helpdesk and admin can assign technicians
        if ($roleName === 'technician') {
            abort(403, 'You are not authorized to assign technicians.');
        }

        $request->validate([
            'technician_id' => 'required|exists:users,id',
        ]);

        $serviceRequest = ServiceRequest::findOrFail($id);

        $serviceRequest->technician_id = $request->technician_id;
        $serviceRequest->status = 'assigned';
        $serviceRequest->save();


            // Prepare message and link
    $message = "Job Card #{$serviceRequest->id} has been assigned to you.";
    $link = url("/JobCards/{$serviceRequest->id}");

    // Send notification to technician
    NotificationService::send($request->technician_id, 'jobcard_assigned', $message, $link);

    // Send notification to customer
    // if ($serviceRequest->customer) {
    //     NotificationService::send($serviceRequest->customer->id, 'jobcard_assigned', "Your service request #{$serviceRequest->id} has been assigned to a technician.", $link);
    // }


        return redirect()->back()->with('success', 'Technician assigned successfully!');
    }

    //assigning a jobcard to another technician
    public function reassignTechnician(Request $request, $id)
    {
        $user = Auth::user();
        $userRole = $user->role;
        $roleName = is_object($userRole) ? strtolower($userRole->name) : strtolower($userRole);
        
        // Only helpdesk and admin can reassign technicians
        if ($roleName === 'technician') {
            abort(403, 'You are not authorized to reassign technicians.');
        }

        $jobCard = ServiceRequest::findOrFail($id);
        
        $request->validate([
            'technician_id' => 'required|exists:users,id',
            'reassign_notes' => 'nullable|string|max:1000'
        ]);

        
        // Update the job card with new technician and reset status
        $jobCard->update([
            'technician_id' => $request->technician_id,
            'status' => 'assigned',
            'reassign_notes' => $request->reassign_notes,
            'reassigned_at' => now(),
            'sent_back_notes' => null, // Clear sent back notes since we're reassigning
            'sent_back_at' => null,
        ]);

        return redirect()->back()->with('success', 'Job card has been reassigned to another technician successfully.');
    }

    public function archive(Request $request, $id)
    {
        $user = Auth::user();
        $userRole = $user->role;
        $roleName = is_object($userRole) ? strtolower($userRole->name) : strtolower($userRole);
        
        // Only helpdesk and admin can archive job cards
        if ($roleName === 'technician') {
            abort(403, 'You are not authorized to archive job cards.');
        }

        $jobCard = ServiceRequest::findOrFail($id);
        
        $request->validate([
            'archive_reason' => 'required|string|in:no_technician_available,customer_collected,beyond_repair,cost_prohibitive,other',
            'archive_notes' => 'nullable|string|max:1000'
        ]);
        
        // Archive the job card
        $jobCard->update([
            'status' => 'archived',
            'archive_reason' => $request->archive_reason,
            'archive_notes' => $request->archive_notes,
            'archived_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Job card has been archived successfully.');
    }

    // functionality for sending back a service request to the helpdesk.
    public function sentBack(Request $request, $id)
    {
      
       $user = Auth::user();
        $userRole = $user->role;
        $roleName = is_object($userRole) ? strtolower($userRole->name) : strtolower($userRole);
        
        $jobCard = ServiceRequest::findOrFail($id);

        // If user is technician, check if they are assigned to this job card
        if ($roleName === 'technician' && $jobCard->technician_id !== $user->id) {
            abort(403, 'You are not authorized to send back this job card.');
        }
        
        $request->validate([
            'sent_back_notes' => 'required|string|min:10|max:1000'
        ]);
        
        // Update the job card status and notes
        $jobCard->update([
            'status' => 'sent_back',
            'sent_back_notes' => $request->sent_back_notes,
            'sent_back_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Job card has been sent back to helpdesk successfully.');
    }


    // Add this method to handle additional fees
public function addAdditionalFees(Request $request, $id)
{
    \Log::info('Additional fees endpoint hit', ['id' => $id, 'data' => $request->all()]);
    
    $jobCard = ServiceRequest::findOrFail($id);
    
    // Validate the request
    $validated = $request->validate([
        'additional_fees' => 'required|numeric|min:0|max:10000',
        'additional_fees_notes' => 'required|string|min:10|max:1000',
    ]);
    
    \Log::info('Validation passed', $validated);
    
    // Check if user is technician and job is in repairing status
    if (auth()->user()->role->name !== 'Technician' || $jobCard->status !== 'repairing') {
        \Log::warning('Unauthorized additional fees attempt', [
            'user_role' => auth()->user()->role->name,
            'job_status' => $jobCard->status
        ]);
        return redirect()->back()->with('error', 'You can only add additional fees when repairing a device.');
    }
    
    try {
        // Update additional fees
        $jobCard->additional_fees = $validated['additional_fees'];
        $jobCard->additional_fees_notes = $validated['additional_fees_notes'];
        $jobCard->additional_fees_added_at = now();
        $jobCard->additional_fees_added_by = auth()->id();
        
        // Calculate and set final cost
        $jobCard->final_cost = $jobCard->calculateFinalCost();
        
        \Log::info('Saving job card with values:', [
            'additional_fees' => $jobCard->additional_fees,
            'final_cost' => $jobCard->final_cost,
            'total_cost' => $jobCard->total_cost
        ]);
        
        $jobCard->save();
        
        \Log::info('Job card updated successfully');
        
        return redirect()->back()->with('success', 'Additional fees added successfully. The final cost has been updated to $' . number_format($jobCard->final_cost, 2));
        
    } catch (\Exception $e) {
        \Log::error('Failed to add additional fees: ' . $e->getMessage(), [
            'exception' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'Failed to add additional fees: ' . $e->getMessage());
    }
}



 //Handle job completion with final cost validation
private function handleJobCompletion(ServiceRequest $jobCard)
{
    // Ensure final_cost is set
    if (is_null($jobCard->final_cost)) {
        $baseCost = $jobCard->total_cost ?? 0;
        $jobCard->final_cost = $baseCost;
        
    }

    return $jobCard;
}



public function updatePayment(Request $request, $id)
{
    $jobCard = ServiceRequest::findOrFail($id);
    
    // Validate the request
    $validated = $request->validate([
        'amount_paid' => 'required|numeric|min:0|max:100000',
        'payment_status' => 'required|in:pending,partial,paid',
        'payment_method' => 'nullable|in:cash,mobile_money,bank_transfer,card,other',
        'transaction_reference' => 'nullable|string|max:100',
    ]);
    
    // Check if job is completed
    if ($jobCard->status !== 'completed') {
        return redirect()->back()->with('error', 'Payments can only be recorded for completed jobs.');
    }
    
    // Auto-calculate payment status based on amount (for safety)
    $finalCost = $jobCard->final_cost ?? 0;
    $amountPaid = $validated['amount_paid'];
    
    if ($amountPaid >= $finalCost) {
        $calculatedStatus = 'paid';
    } elseif ($amountPaid > 0) {
        $calculatedStatus = 'partial';
    } else {
        $calculatedStatus = 'pending';
    }
    
    // Use the calculated status (ignore user input for status)
    $validated['payment_status'] = $calculatedStatus;
    
    try {
        // Update payment details
        $jobCard->amount_paid = $validated['amount_paid'];
        $jobCard->payment_status = $validated['payment_status'];
        $jobCard->payment_method = $validated['payment_method'];
        $jobCard->transaction_reference = $validated['transaction_reference'];
        
        // Set paid_at timestamp if fully paid
        if ($validated['payment_status'] === 'paid') {
            $jobCard->paid_at = now();
        } else {
            $jobCard->paid_at = null;
        }
        
        $jobCard->save();
        return redirect()->back()->with('success', 'Payment details updated successfully.');
        
    } catch (\Exception $e) {
        \Log::error('Payment update failed: ' . $e->getMessage(), [
            'job_card_id' => $id,
            //'user_id' => $user->id,
            'data' => $validated
        ]);
        
        return redirect()->back()->with('error', 'Failed to update payment: ' . $e->getMessage());
    }
}


public function jobList(Request $request)
{
    $user = Auth::user();
    $userRole = $user->role;
    $roleName = is_object($userRole) ? strtolower($userRole->name) : strtolower($userRole);
    
    // Get filter from query parameter or default to 'all'
    $filter = $request->query('filter', 'all');
    $search = $request->query('search', '');
    $timeFilter = $request->query('time_filter', 'latest');
    
    // Base query
    $query = ServiceRequest::with(['device', 'customer', 'technician']);
    
    // Apply role-based filtering
    if ($roleName === 'technician') {
        $query->where('technician_id', $user->id);
    }
    
    // Apply status filter
    if ($filter !== 'all') {
        $query->where('status', $filter);
    }
    
    // Apply time-based filtering
    switch ($timeFilter) {
        case 'month':
            $query->where('created_at', '>=', now()->startOfMonth());
            break;
        case 'last_month':
            $query->whereBetween('created_at', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()
            ]);
            break;
        case 'last_3_months':
            $query->where('created_at', '>=', now()->subMonths(3)->startOfMonth());
            break;
        case 'latest':
        default:
            // No additional time filtering, just use latest ordering
            break;
    }
    
    // Apply search filter
    if (!empty($search)) {
        $query->where(function($q) use ($search) {
            $q->whereHas('device', function($deviceQuery) use ($search) {
                $deviceQuery->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('customer', function($customerQuery) use ($search) {
                $customerQuery->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('technician', function($techQuery) use ($search) {
                $techQuery->where('name', 'like', "%{$search}%");
            })
            ->orWhere('id', 'like', "%{$search}%");
        });
    }
    
    $requests = $query->latest()->paginate(12);
    
    return view('JobCard.job-list', compact(
        'requests', 
        'filter',
        'search',
        'timeFilter'
    ));
}




private function notifyStatusUpdate($jobCard, $newStatus, $senderId)
{
    $link = url("/JobCards/{$jobCard->id}");
    $msg  = $this->getStatusMessages($jobCard, $newStatus);

    // Helper function: prevent sending notification to the sender
    $send = function ($userId, $message) use ($senderId, $link) {
        if ($userId && $userId != $senderId) {
            NotificationService::send($userId, 'jobcard_status_update', $message, $link);
        }
    };

    // --- Notify Technician ---
    $send($jobCard->technician_id, $msg['technician']);

    // --- Notify Customer ---
    $send($jobCard->customer_id, $msg['customer']);

    // --- Notify Admins ---
    $admins = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->get();
    foreach ($admins as $admin) {
        $send($admin->id, $msg['admin']);
    }

    // --- Notify Helpdesk ---
    $helpdeskUsers = User::whereHas('role', fn($q) => $q->where('name', 'helpdesk'))->get();
    foreach ($helpdeskUsers as $helpdesk) {
        $send($helpdesk->id, $msg['helpdesk']);
    }
}


private function getStatusMessages($jobCard, $status)
{
    $statusLabel = ucfirst(str_replace('_', ' ', $status));

    // Default fallback message
    $default = [
        'technician' => "Job Card #{$jobCard->id} status updated to {$statusLabel}.",
        'customer'   => "Your service request #{$jobCard->id} is now {$statusLabel}.",
        'admin'      => "Job Card #{$jobCard->id} status updated to {$statusLabel}.",
        'helpdesk'   => "Job Card #{$jobCard->id} updated to {$statusLabel}.",
    ];

    // Custom messages for each status
    $messages = [
        'submitted' => [
            'technician' => "A new Job Card #{$jobCard->id} has been submitted and is awaiting assignment.",
            'customer'   => "Your request #{$jobCard->id} has been submitted successfully.",
            'admin'      => "New Job Card #{$jobCard->id} created by a customer.",
            'helpdesk'   => "A new Job Card #{$jobCard->id} has been submitted.",
        ],

        'assessed' => [
            'technician' => "Job Card #{$jobCard->id} has been assessed. Please review the findings.",
            'customer'   => "Your device (#{$jobCard->id}) has been assessed. We will update you soon.",
            'admin'      => "Job Card #{$jobCard->id} marked as assessed.",
            'helpdesk'   => "Assessment completed for Job Card #{$jobCard->id}.",
        ],

        'in_progress' => [
            'technician' => "Work started on Job Card #{$jobCard->id}.",
            'customer'   => "Your device (#{$jobCard->id}) is now being worked on.",
            'admin'      => "Technician has started working on Job Card #{$jobCard->id}.",
            'helpdesk'   => "Job Card #{$jobCard->id} is currently in progress.",
        ],

        'diagnosis' => [
            'technician' => "Diagnosis completed for Job Card #{$jobCard->id}.",
            'customer'   => "Diagnosis for your device (#{$jobCard->id}) has been completed.",
            'admin'      => "Job Card #{$jobCard->id} moved to diagnosis stage.",
            'helpdesk'   => "Diagnosis completed for Job Card #{$jobCard->id}.",
        ],

        'completed' => [
            'technician' => "Job Card #{$jobCard->id} has been completed.",
            'customer'   => "Good news! Your device (#{$jobCard->id}) is ready for collection.",
            'admin'      => "Job Card #{$jobCard->id} completed successfully.",
            'helpdesk'   => "Job Card #{$jobCard->id} has been completed.",
        ],

        'unsuccessful' => [
            'technician' => "Repair was unsuccessful for Job Card #{$jobCard->id}.",
            'customer'   => "Unfortunately, the repair for your device (#{$jobCard->id}) was not successful.",
            'admin'      => "Repair attempt failed for Job Card #{$jobCard->id}.",
            'helpdesk'   => "Job Card #{$jobCard->id} marked as unsuccessful.",
        ],
    ];

    return $messages[$status] ?? $default;
}


}