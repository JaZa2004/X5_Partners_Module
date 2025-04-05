<?php

namespace App\Http\Controllers;

use App\Models\Agreementterm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AgreementtermController extends Controller
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
        $terms = Agreementterm::all();
        return response()->json($terms, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) return $adminCheck;

        $validated = $request->validate([
            'term' => 'required|string|max:255',
            'description' => 'required|string',
            'partnership_id' => 'required|exists:partnerships,id',
        ]);

        $term = Agreementterm::create($validated);

        return response()->json($term, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $term = Agreementterm::find($id);
        if (!$term) {
            return response()->json(['error' => 'Agreement term not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($term, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) return $adminCheck;

        $term = Agreementterm::find($id);
        if (!$term) {
            return response()->json(['error' => 'Agreement term not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'term' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'partnership_id' => 'sometimes|required|exists:partnerships,id',
        ]);

        $term->update($validated);

        return response()->json($term, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) return $adminCheck;

        $term = Agreementterm::find($id);
        if (!$term) {
            return response()->json(['error' => 'Agreement term not found'], Response::HTTP_NOT_FOUND);
        }

        $term->delete();
        return response()->json(['message' => 'Agreement term deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
