<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
        // Only allow admin to see the list of users
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $users = User::all();
        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only allow admin to create new users
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']), // Encrypt password
        ]);

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Anyone can view a user, but let's check if the user exists
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Only allow admin to update users
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        // If the password is provided, encrypt it
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Only allow admin to delete users
        $adminCheck = $this->checkAdminRole();
        if ($adminCheck) {
            return $adminCheck;
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
