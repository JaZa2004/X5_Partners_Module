<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // Admin check helper
    private function checkAdminRole()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], Response::HTTP_FORBIDDEN);
        }
        return null;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::all();
        return response()->json($addresses, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) return $adminCheck;

        $validated = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:255',
            'zip_code' => 'required|integer',
        ]);

        $address = Address::create($validated);

        return response()->json($address, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $address = Address::find($id);
        if (!$address) {
            return response()->json(['error' => 'Address not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($address, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) return $adminCheck;

        $address = Address::find($id);
        if (!$address) {
            return response()->json(['error' => 'Address not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'partner_id' => 'sometimes|required|exists:partners,id',
            'country' => 'sometimes|required|string|max:100',
            'city' => 'sometimes|required|string|max:100',
            'street' => 'sometimes|required|string|max:255',
            'zip_code' => 'sometimes|required|integer',
        ]);

        $address->update($validated);

        return response()->json($address, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) return $adminCheck;

        $address = Address::find($id);
        if (!$address) {
            return response()->json(['error' => 'Address not found'], Response::HTTP_NOT_FOUND);
        }

        $address->delete();
        return response()->json(['message' => 'Address deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
