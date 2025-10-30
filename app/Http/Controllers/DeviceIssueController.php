<?php

namespace App\Http\Controllers;

use App\Models\DeviceIssue;
use App\Models\issueCategory;
use Illuminate\Http\Request;

class DeviceIssueController extends Controller
{
    public function index()
    {
        $issues = DeviceIssue::with('issueCategory')->paginate(10);
        return view('device_issues.index', compact('issues'));
    }

    public function create()
    {
        $issueCategories = issueCategory::all();
        return view('device_issues.create',compact('issueCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'issue' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DeviceIssue::create($request->all());

        return redirect()->route('device_issues.index')
            ->with('success', 'Device issue created successfully.');
    }

    public function show(DeviceIssue $device_issue)
    {
        return view('device_issues.show', compact('device_issue'));
    }

    public function edit(DeviceIssue $device_issue)
    {
        $issueCategories = issueCategory::all();
        return view('device_issues.edit', compact('device_issue', 'issueCategories'));
    }

    public function update(Request $request, DeviceIssue $device_issue)
    {
        $request->validate([
            'issue' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $device_issue->update($request->all());

        return redirect()->route('device_issues.index')
            ->with('success', 'Device issue updated successfully.');
    }

    public function destroy(DeviceIssue $device_issue)
    {
        $device_issue->delete();

        return redirect()->route('device_issues.index')
            ->with('success', 'Device issue deleted successfully.');
    }
}
