<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $consultation_fee = Setting::get('consultation_fee', 0);
        return view('admin.settings.index', compact('consultation_fee'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'consultation_fee' => 'required|numeric|min:0',
        ]);

        Setting::set('consultation_fee', $request->consultation_fee);

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
