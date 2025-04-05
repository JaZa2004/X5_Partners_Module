<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    // Function to check admin role
    private function checkAdminRole()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], Response::HTTP_FORBIDDEN);
        }
        return null; // Return null if the user has the correct role
    }

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
        // Check if the user is an admin
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'partner_logo' => 'nullable|string',
            'partner_type' => 'nullable|string'
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
        // Check if the user is an admin
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'company_name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:20',
            'partner_logo' => 'sometimes|nullable|string',
            'partner_type' => 'sometimes|nullable|string'

        ]);

        $partner->update($validated);

        return response()->json($partner, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check if the user is an admin
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }

        $partner->delete();
        return response()->json(['message' => 'Partner deleted successfully'], Response::HTTP_NO_CONTENT);
    }

    public function representatives(int $id){
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($partner->representatives, Response::HTTP_OK);
    }

    public function addresses(int $id){
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($partner->addresses, Response::HTTP_OK);
    }

    public function partnerships(int $id){
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($partner->partnerships, Response::HTTP_OK);
    }
}
