<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Setting;
use App\Models\DeviceIssue;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ServiceRequestController extends Controller
{
    public function selectDevice()
    {
        $devices = Device::all();
        return view('service_requests.select-device', compact('devices'));
    }

    // 2. Show issues for selected device 
public function selectIssues($deviceId)
{
    $device = Device::with(['issues.issueCategory'])->findOrFail($deviceId);
    
    // Get issues with their categories through the many-to-many relationship
    $deviceIssues = $device->issues;
    
    //Group by category name
    $issuesByCategory = $deviceIssues->groupBy('issueCategory.name');


    //fetch consultation fee from settings table
    $consultationFee = Setting::where('key', 'consultation_fee')->value('value') ?? 0;

    return view('service_requests.select-issues', compact('device', 'issuesByCategory' , 'consultationFee' ));
}


    // 3. Preview Quote
    // public function previewQuote(Request $request, $deviceId)
    // {
    //     $device = Device::findOrFail($deviceId);

    //     $request->validate([
    //         'issues' => 'required|array|min:1',
    //         'costs'  => 'required|array',
    //     ]);

    //     $selectedIssues = DeviceIssue::whereIn('id', $request->issues)->get();
    //     $costs = $request->costs;
    //     $totalCost = 0;

    //     foreach ($request->issues as $issueId) {
    //         $totalCost += (float)($costs[$issueId] ?? 0);
    //     }

    //     session([
    //         'service_request.device_id' => $device->id,
    //         'service_request.issues'    => $request->issues,
    //         'service_request.costs'     => $costs,
    //         'service_request.total'     => $totalCost,
    //     ]);

    //     return view('service_requests.preview-quote', compact('device', 'selectedIssues', 'costs', 'totalCost'));
    // }

// 4. Store Service Request (Simplified)
public function store(Request $request)
{
    $request->validate([
        'device_id' => 'required|exists:devices,id',
        'issues' => 'required|array|min:1',
        'costs' => 'required|array',
    ]);

    try {
        $totalCost = 0;
        $issueAttachments = [];

        // Prepare issues and calculate total
        foreach ($request->issues as $issueId) {
            $cost = (float) ($request->costs[$issueId] ?? 0);
            $totalCost += $cost;
            
            $issueAttachments[$issueId] = [
                'cost' => $cost,
                 'issue_id' => $issueId,
                'created_at' => now(),
                'updated_at' => now(),

            ];
        }


        // Create service request
        $serviceRequest = ServiceRequest::create([
            
            'customer_id' => Auth::id(),
            'device_id' => $request->device_id,
            'total_cost' => $totalCost,
            'status' => 'Submitted',
        ]);

        
        // Attach issues to the custom pivot table
        $serviceRequest->issues()->attach($issueAttachments);

        // Redirect to show the created service request, not back to device selection
        return redirect()->route('service-requests.show', $serviceRequest->id)
                         ->with('success', 'Service request submitted successfully! Our team will contact you soon.');

    } catch (\Exception $e) {
        \Log::error('Service Request Creation Failed:', [
            'error' => $e->getMessage(),
            'user_id' => Auth::id(),
            'device_id' => $request->device_id,
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()
                         ->with('error', 'Failed to submit service request: ' . $e->getMessage())
                         ->withInput();
    }
        
}

    // 5. Show request details
    public function show($id)
    {
        $serviceRequest = ServiceRequest::with(['device', 'issues'])->findOrFail($id);
        return view('service_requests.show', compact('serviceRequest'));
    }


//     public function selectIssues(Device $device)
// {
//     $issuesByCategory = $device->issues()->withPivot('cost')->get()->groupBy('category.name');



//     return view('service_requests.select-issues', compact('device', 'issuesByCategory', 'consultationFee'));
// }


    // 6. Download Quote as PDF
    // public function downloadQuote()
    // {
    //     $deviceId  = session('service_request.device_id');
    //     $issues    = session('service_request.issues');
    //     $costs     = session('service_request.costs');
    //     $totalCost = session('service_request.total');

    //     if (!$deviceId || !$issues) {
    //         return redirect()->route('service-requests.select-device')
    //                          ->with('error', 'No quote data available.');
    //     }

    //     $device = Device::findOrFail($deviceId);
    //     $selectedIssues = DeviceIssue::whereIn('id', $issues)->get();

    //     $pdf = Pdf::loadView('service_requests.pdf-quote', compact('device', 'selectedIssues', 'costs', 'totalCost'));

    //     return $pdf->download('service_quote.pdf');
    // }
}