<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\issueCategory;

class DeviceIssueCategoryController extends Controller
{
    //
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $issueCategories = issueCategory::latest()->paginate(6);
        return view('issueCategories.index', compact('issueCategories'));
    }

       // Show the form for creating a new resource.
    public function create()
    {
        return view('issueCategories.create');
    }

         // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        issueCategory::create($request->all());

        return redirect()->route('issueCategories.index')
                         ->with('success', 'Issue Category created successfully.');
    }

    //Display the specified resource.
    public function show(issueCategory $issueCategory)
    {
        return view('issueCategories.show', compact('issueCategory'));
    }

    //Show the form for editing the specified resource.
    public function edit(issueCategory $issueCategory)
    {
        return view('issueCategories.edit', compact('issueCategory'));
    }

         // Update the specified resource in storage.
    public function update(Request $request, issueCategory $issueCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $issueCategory->update($request->all());

        return redirect()->route('issueCategories.index')
                         ->with('success', 'Issue category updated successfully');
    }

         // Remove the specified resource from storage.
    public function destroy(issueCategory $issueCategory)
    {
        $issueCategory->delete();

        return redirect()->route('issueCategories.index')
                         ->with('success', 'Issue category deleted successfully');
    }

}
