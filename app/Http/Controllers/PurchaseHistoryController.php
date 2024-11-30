<?php

namespace App\Http\Controllers;

use App\Models\PurchaseHistory;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseHistory $purchaseHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseHistory $purchaseHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseHistory $purchaseHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseHistory $purchaseHistory)
    {
        //
    }

    public function soldReport(Request $request)
    {
        $histories=PurchaseHistory::SearchDateRange([$request->get('date_start'), $request->get('date_end')])->get();
        $totalMasks = $histories->reduce(function ($carry, $history) {
            return $carry + $history->mask_quantity_per_pack; // 使用模型中的方法
        }, 0);
        $reports=[
            'count' => $histories->count(),
            'dollar' => $histories->sum('transaction_amount'),
            'totalMasks' => $totalMasks,
        ];
        return response()->json(['result' => 'success', 'reports' => $reports]);
    }
}
