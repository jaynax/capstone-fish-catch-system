<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boat;

class BoatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    /**
     * Search for a boat by name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return response()->json(['status' => 'error', 'message' => 'Search query is required']);
        }

        $boat = Boat::where('boat_name', 'LIKE', '%' . $query . '%')
                    ->first();

        if (!$boat) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'No matching boat found'
            ]);
        }

        return response()->json([
            'status' => 'found',
            'data' => $boat
        ]);
    }
}
