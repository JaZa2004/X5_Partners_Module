<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PartnershipController extends Controller
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
        // Check if the user is an admin
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $validated = $request->validate([
            'partner_id'=>'required|integer',
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
        // Check if the user is an admin
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $partnership = Partnership::find($id);
        if (!$partnership) {
            return response()->json(['error' => 'Partnership not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
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
        // Check if the user is an admin
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $partnership = Partnership::find($id);
        if (!$partnership) {
            return response()->json(['error' => 'Partnership not found'], Response::HTTP_NOT_FOUND);
        }

        $partnership->delete();
        return response()->json(['message' => 'Partnership deleted successfully'], Response::HTTP_NO_CONTENT);
    }

    public function documents(int $id){
        $partnership = Partnership::find($id);
        if (!$partnership) {
            return response()->json(['error' => 'No Partnership found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($partnership->documents, Response::HTTP_OK);
    }

    public function agreementterms(int $id){
        $partnership = Partnership::find($id);
        if (!$partnership) {
            return response()->json(['error' => 'No Partnership found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($partnership->agreementterms, Response::HTTP_OK);
    }

    public function services(int $id){
        $partnership = Partnership::find($id);
        if (!$partnership) {
            return response()->json(['error' => 'No Partnership found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($partnership->services, Response::HTTP_OK);
    }
}
