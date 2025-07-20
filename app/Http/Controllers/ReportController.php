<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    // app/Http/Controllers/ReportController.php
public function sales(Request $request)
{
    $sales = Sale::with('user')
        ->when($request->date_range, function ($query) use ($request) {
            $dates = explode(' - ', $request->date_range);
            $query->whereBetween('created_at', [Carbon::parse($dates[0]), Carbon::parse($dates[1])]);
        })
        ->latest()
        ->paginate(25);

    return view('reports.sales', compact('sales'));
}

public function dailySales()
{
    $data = Sale::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(grand_total) as total')
    )
    ->groupBy('date')
    ->orderBy('date', 'DESC')
    ->get();

    return response()->json($data);
}
}
