<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Harvest;
use App\Models\Farmer;

class HarvestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $harvests = Harvest::with('farmer')->get();
        
        if ($harvests->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No harvest records found'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $harvests
        ]);
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
         $validated = $request->validate([
            'farmer_id' => 'required|exists:farmers,farmer_id',
            'season' => 'required|in:dry,wet',
            'planting_date' => 'required|date',
            'harvest_date' => 'required|date|after:planting_date',
            'yield_amount' => 'required|numeric|min:0|max:50',
            'variety_used' => 'required|string|max:255|min:2',
        ]);

        $harvest = Harvest::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Harvest record created successfully',
            'data' => $harvest->load('farmer')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $harvest = Harvest::with('farmer')->find($id);
        
        if (!$harvest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Harvest record not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $harvest
        ]);
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
        $harvest = Harvest::find($id);
        
        if (!$harvest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Harvest record not found'
            ], 404);
        }

        $validated = $request->validate([
            'farmer_id' => 'required|exists:farmers,farmer_id',
            'season' => 'required|in:dry,wet',
            'planting_date' => 'required|date',
            'harvest_date' => 'required|date|after:planting_date',
            'yield_amount' => 'required|numeric|min:0|max:50',
            'variety_used' => 'required|string|max:255|min:2',
        ]);

        $harvest->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Harvest record updated successfully',
            'data' => $harvest->load('farmer')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $harvest = Harvest::find($id);
        
        if (!$harvest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Harvest record not found'
            ], 404);
        }

        $harvest->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Harvest record deleted successfully'
        ]);
    }

     public function getByFarmer(int $farmerId)
    {
        $farmer = Farmer::find($farmerId);
        
        if (!$farmer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Farmer not found'
            ], 404);
        }

        $harvests = Harvest::where('farmer_id', $farmerId)->with('farmer')->get();

        return response()->json([
            'status' => 'success',
            'data' => $harvests
        ]);
    }

    public function getBySeason(string $season)
    {
        if (!in_array($season, ['dry', 'wet'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid season. Must be "dry" or "wet"'
            ], 400);
        }

        $harvests = Harvest::where('season', $season)->with('farmer')->get();

        if ($harvests->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No harvest records found for ' . $season . ' season'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $harvests
        ]);
    }
}
