<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PartnershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partnerships = Partnership::all();
        return response()->json($partnerships, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'partnership_type' => 'required|string|max:255',
            'status' => 'required|in:active,pending,expired',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $partnership = Partnership::create($validated);

        return response()->json($partnership, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $partnership = Partnership::find($id);
        if (!$partnership) {
            return response()->json(['error' => 'Partnership not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($partnership, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $partnership = Partnership::find($id);
        if (!$partnership) {
            return response()->json(['error' => 'Partnership not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'partnership_type' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:active,pending,expired',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
        ]);

        $partnership->update($validated);

        return response()->json($partnership, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partnership = Partnership::find($id);
        if (!$partnership) {
            return response()->json(['error' => 'Partnership not found'], Response::HTTP_NOT_FOUND);
        }

        $partnership->delete();
        return response()->json(['message' => 'Partnership deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
