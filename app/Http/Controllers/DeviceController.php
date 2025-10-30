<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Category;
use App\Models\DeviceIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    public function __construct()
    {
        // Automatically apply policy methods to resource actions
        $this->authorizeResource(Device::class, 'device');
    }

    public function index()
    {
        $devices = Device::with('category')->paginate(10);
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        $categories = Category::all();
        $issues = DeviceIssue::all();
        return view('devices.create', compact('categories', 'issues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'issues' => 'array|exists:device_issues,id',
            'brand' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ]);

        //create a path for the image
        $path = $request->file('image')->store('devices', 'public');

        $device = Device::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'brand' => $request->brand,
            'image' => $path,
        ]);

        if ($request->has('issues')) {
            $device->issues()->sync($request->issues);
        }

        return redirect()->route('devices.index')->with('success', 'Device created successfully.');
    }

    public function show(Device $device)
    {
        $device->load('category', 'issues');
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        $categories = Category::all();
        $issues = DeviceIssue::all();
        $device->load('issues'); //or $device->with('issues')->find($device->id)
        return view('devices.edit', compact('device', 'categories', 'issues'));
    }

    public function update(Request $request, Device $device)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'issues' => 'array|exists:device_issues,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'category_id']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($device->image) {
                Storage::disk('public')->delete($device->image);
            }
            $data['image'] = $request->file('image')->store('devices', 'public');
        }

        $device->update($data);

        if ($request->has('issues')) {
            $device->issues()->sync($request->issues);
        } else {
            $device->issues()->detach();
        }

        return redirect()->route('devices.index')->with('success', 'Device updated successfully.');
    }

    public function destroy(Device $device)
    {
        // check if the device has image, then delete the image.
        if ($device->image) {
            Storage::disk('public')->delete($device->image);
        }
        $device->issues()->detach(); //then detach the attached issues
        $device->delete();

        return redirect()->route('devices.index')->with('success', 'Device deleted successfully.');
    }

    public function assignIssues(Device $device)
    {
    // Get IDs of already assigned issues
    $assignedIssueIds = $device->issues()->pluck('device_issues.id')->toArray();

    // Load only unassigned issues
    $issues = DeviceIssue::whereNotIn('id', $assignedIssueIds)->get();

    return view('devices.assign-issues', compact('device', 'issues'));
    }

    public function storeAssignedIssues(Request $request, Device $device)
{
    $validated = $request->validate([
        'issues' => 'array',
        'issues.*' => 'exists:device_issues,id',
        'costs' => 'array',
    ]);

    $syncData = [];
    foreach ($request->issues ?? [] as $issueId) {
        $cost = $request->costs[$issueId] ?? null;

        if ($cost === null) {
            return back()->withErrors(['costs' => "Cost is required for issue ID {$issueId}."]);
        }

        $syncData[$issueId] = ['cost' => $cost];
    }

      //with syncWithoutDetaching we can assign more issues without detaching the already assigned
    $device->issues()->syncWithoutDetaching($syncData);


    return redirect()->route('devices.show', $device->id)
                     ->with('success', 'Issues assigned successfully.');
    }

 }
