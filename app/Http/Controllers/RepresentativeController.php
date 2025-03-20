<?php

namespace App\Http\Controllers;

use App\Models\Representative;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RepresentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $representatives = Representative::all();
        return response()->json($representatives, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:representatives,email',
            'phone' => 'required|string|max:20',
            'position_at_company' => 'required|string|max:255',
        ]);

        $representative = Representative::create($validated);

        return response()->json($representative, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $representative = Representative::find($id);
        if (!$representative) {
            return response()->json(['error' => 'Representative not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($representative, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $representative = Representative::find($id);
        if (!$representative) {
            return response()->json(['error' => 'Representative not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:representatives,email,' . $id,
            'phone' => 'sometimes|required|string|max:20',
            'position_at_company' => 'sometimes|required|string|max:255',
        ]);

        $representative->update($validated);

        return response()->json($representative, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $representative = Representative::find($id);
        if (!$representative) {
            return response()->json(['error' => 'Representative not found'], Response::HTTP_NOT_FOUND);
        }

        $representative->delete();
        return response()->json(['message' => 'Representative deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
