<?php

namespace App\Http\Controllers;

use App\Http\Resources\MaskCollection;
use App\Models\Mask;
use Illuminate\Http\Request;

class MaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $masks = Mask::SearchPharmacy($request->get('pharmacy_id'))
            ->SortName($request->get('name_sort'))
            ->SortPrice($request->get('price_sort'))
            ->get();

        return response()->json(['result' => 'success', 'masks' => new MaskCollection($masks)]);
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
    public function show(Mask $mask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mask $mask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mask $mask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mask $mask)
    {
        //
    }
}
