<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


class FarmerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $farmers = Farmer::with('harvests')->get();
        
        if ($farmers->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No farmers found'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $farmers
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
            'farmer_name' => 'required|string|max:255|min:3',
            'contact_number' => 'required|string|regex:/^09[0-9]{9}$/',
            'farm_location' => 'required|string|max:255|min:3',
            'farm_size' => 'required|numeric|min:0.1|max:1000',
        ]);

        $farmer = Farmer::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Farmer created successfully',
            'data' => $farmer
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $farmer = Farmer::with('harvests')->find($id);
        
        if (!$farmer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Farmer not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $farmer
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
    public function update(Request $request, int $id)
    {
         $farmer = Farmer::find($id);
        
        if (!$farmer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Farmer not found'
            ], 404);
        }

        $validated = $request->validate([
            'farmer_name' => 'required|string|max:255|min:3',
            'contact_number' => 'required|string|regex:/^09[0-9]{9}$/',
            'farm_location' => 'required|string|max:255|min:3',
            'farm_size' => 'required|numeric|min:0.1|max:1000',
        ]);

        $farmer->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Farmer updated successfully',
            'data' => $farmer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $farmer = Farmer::find($id);
        
        if (!$farmer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Farmer not found'
            ], 404);
        }

        $farmer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Farmer deleted successfully'
        ]);
    }
}
