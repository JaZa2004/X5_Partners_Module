<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::all();
        return response()->json($partners, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'partner_logo' => 'nullable|string',
            'representative_id' => 'required|exists:representatives,id',
        ]);

        $partner = Partner::create($validated);

        return response()->json($partner, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($partner, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'company_name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:20',
            'partner_logo' => 'sometimes|nullable|string',
            'representative_id' => 'sometimes|required|exists:representatives,id',
        ]);

        $partner->update($validated);

        return response()->json($partner, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }

        $partner->delete();
        return response()->json(['message' => 'Partner deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
