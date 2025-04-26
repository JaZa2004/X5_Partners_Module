<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
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
        $documents = Document::all();
        return response()->json($documents);
    }

    public function store(Request $request)
    {
        // Check if the user is an admin
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'required|string',
            'uploaded_by' => 'required|exists:users,id',
            'partnership_id' => 'required|exists:partnerships,id',
        ]);

        $document = Document::create($validated);

        return response()->json($document, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return response()->json($document);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        // Check if the user is an admin
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'file_path' => 'sometimes|string',
            'uploaded_by' => 'sometimes|exists:users,id',
            'partnership_id' => 'sometimes|exists:partnerships,id',
        ]);

        $document->update($validated);

        return response()->json($document);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        // Check if the user is an admin
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $document->delete();
        return response()->json(['message' => 'Document deleted successfully']);
    }
}
