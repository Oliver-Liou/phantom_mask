<?php

namespace App\Http\Controllers;

use App\Http\Resources\PharmacyCollection;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $pharmacies = Pharmacy::with('openingHours')
            ->SearchOpening($request->get('time'), $request->get('day_of_week'))
            ->SearchMaskPriceRangeAndCount($request->get('mask_count'), $request->get('mask_condition'),
                [$request->get('mask_price_min', 0), $request->get('mask_price_max')])
            ->get();

        return response()->json(['result' => 'success', 'pharmacies' => new PharmacyCollection($pharmacies)]);
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
    public function show(Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        //
    }
}
