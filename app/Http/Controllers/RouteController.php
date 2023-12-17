<?php

namespace App\Http\Controllers;

use App\Http\Resources\LandmarkResource;
use App\Models\Landmarks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RouteController extends Controller
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
    public function store(Request $request)
    {
        return response()->json([
            'message' => 'User created successfully',
            'data' => $request->all()
        ], 201);
    }

    /**
     * creeate route from users location
     */
    public function route(Request $request)
    {
        return response()->json([
            'message' => 'Route created successfully',
            'data' => $request->all()
        ], 201);
    }

    /**
     * Display the specified resource.
     */

    public function getLandmarksBetween($from, $to)
    {
        $from = strtolower($from);
        $to = strtolower($to);
        // Find the landmark with the given 'from' value
        $path = [$from];

        while ($from !== $to) {
            $landmark = Landmarks::where('name', $from)->first();

            if (!$landmark) {
                return response()->json(['status' => 400, "data" => []]);
            }

            $from = $landmark->routes;
            $path[] = $from;
        }

        // Fetch the details of landmarks in the path
        $landmarks = Landmarks::whereIn('name', $path)->get();

        // Transform the data into the desired format using a resource
        $landmarkResource = LandmarkResource::collection($landmarks);

        if ($landmarkResource){
            return response()->json(['status' => 200, "data" => $landmarkResource]);
        }
        // Return an error message if 'from' or 'to' landmarks are not found
        return response()->json(['status' => 400, "data" => []]);
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
