<?php

namespace App\Http\Controllers;

use App\Models\Mask;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->get('term');
        $pharmacies = Pharmacy::SearchName($term)->get()->map(function ($data) {
            return[
                'id' => $data->id,
                'name' => $data->name,
                'type' => 'pharmacy',
            ];
        })->toArray();
        $masks = Mask::SearchName($term)->get()->map(function ($data) {
            return[
                'id' => $data->id,
                'name' => $data->name,
                'type' => 'mask',
            ];
        })->toArray();

        $results = array_merge($pharmacies, $masks);
        // 計算相似度並排序
        $sortedResults = collect($results)->map(function ($item) use ($term) {
            similar_text(strtolower($term), strtolower($item['name']), $percent);
            $item['relevance'] = $percent; // 記錄相似度百分比
            return $item;
        })->sortByDesc('relevance') // 按相似度排序
        ->values();

        return response()->json(['result' => 'success', 'data' => $sortedResults]);
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
