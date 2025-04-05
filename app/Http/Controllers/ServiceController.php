<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    private function checkAdminRole()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], Response::HTTP_FORBIDDEN);
        }
        return null;
    }

    public function index()
    {
        if ($error = $this->checkAdminRole()) return $error;

        $services = Service::with('partnership')->get();
        return response()->json($services, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        if ($error = $this->checkAdminRole()) return $error;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_type' => 'required|in:free,discount,full_paid',
            'price' => 'nullable|numeric|min:0',
            'partnership_id' => 'required|exists:partnerships,id',
            'discount_percentage' => 'nullable|numeric|between:0,100',
        ]);

        if ($request->cost_type === 'discount' && !$request->has('discount_percentage')) {
            return response()->json(['error' => 'Discount percentage is required when cost type is discount'], 422);
        };

        if ($validated['cost_type'] === 'free') {
            $validated['price'] = 0;
            $validated['discount_percentage'] = null;
        }
        if ($validated['discount_percentage'] == 100) {
            $validated['cost_type'] = "free";
        }

        $service = Service::create($validated);
        return response()->json($service, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        if ($error = $this->checkAdminRole()) return $error;

        $service = Service::with('partnership')->find($id);
        if (!$service) {
            return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($service, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        if ($error = $this->checkAdminRole()) return $error;

        $service = Service::find($id);
        if (!$service) {
            return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'cost_type' => 'sometimes|required|in:free,discount,full_paid',
            'price' => 'nullable|numeric|min:0',
            'partnership_id' => 'sometimes|required|exists:partnerships,id',
            'discount_percentage' => 'nullable|numeric|between:0,100',
        ]);

        if (isset($validated['cost_type']) && $validated['cost_type'] === 'free') {
            $validated['price'] = 0;
        }
        if ($request->cost_type === 'discount' && !$request->has('discount_percentage')) {
            return response()->json(['error' => 'Discount percentage is required when cost type is discount'], 422);
        };

        if ($validated['cost_type'] === 'free') {
            $validated['price'] = 0;
            $validated['discount_percentage'] = null;
        }
        if ($validated['discount_percentage'] == 100) {
            $validated['cost_type'] = "free";
            $validated['price'] = 0;
        }

        $service->update($validated);
        return response()->json($service, Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        if ($error = $this->checkAdminRole()) return $error;

        $service = Service::find($id);
        if (!$service) {
            return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }

        $service->delete();
        return response()->json(['message' => 'Service deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
