<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /** 
     * Store a newly created resource in storage.
     */
  // app/Http/Controllers/SaleController.php
public function store(Request $request)
{
    DB::transaction(function () use ($request) {
        $sale = Sale::create([
            'invoice_number' => 'INV-' . time(),
            'user_id' => auth()->id(),
            'total_amount' => $request->total,
            'grand_total' => $request->total,
            'payment_method' => 'cash'
        ]);

        foreach ($request->items as $item) {
            $sale->items()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['subtotal']
            ]);

            // Update product stock
            Product::find($item['id'])->decrement('quantity', $item['quantity']);
        }
    });

    return response()->json(['success' => true]);
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
