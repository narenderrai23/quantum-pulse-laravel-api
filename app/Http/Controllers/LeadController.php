<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    /**
     * GET /api/leads
     * Returns all leads sorted by newest first.
     */
    public function index(): JsonResponse
    {
        $leads = Lead::orderBy('created_at', 'desc')
            ->get()
            ->map(fn(Lead $lead) => $lead->toApiArray());

        return response()->json($leads);
    }

    /**
     * POST /api/leads
     * Creates a new lead.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'city'    => 'nullable|string|max:255',
            'project' => 'nullable|string',
        ]);

        $lead = Lead::create([
            ...$validated,
            'lead_id' => Str::random(9),
            'status'  => 'new',
        ]);

        return response()->json($lead->toApiArray(), 201);
    }

    /**
     * GET /api/leads/{id}
     */
    public function show(string $id): JsonResponse
    {
        $lead = Lead::where('lead_id', $id)->firstOrFail();

        return response()->json($lead->toApiArray());
    }

    /**
     * PATCH /api/leads/{id}
     * Update lead status or other fields.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $lead = Lead::where('lead_id', $id)->firstOrFail();

        $validated = $request->validate([
            'status'  => 'sometimes|string|max:50',
            'name'    => 'sometimes|string|max:255',
            'email'   => 'sometimes|email|max:255',
            'phone'   => 'sometimes|nullable|string|max:50',
            'city'    => 'sometimes|nullable|string|max:255',
            'project' => 'sometimes|nullable|string',
        ]);

        $lead->update($validated);

        return response()->json($lead->toApiArray());
    }

    /**
     * DELETE /api/leads/{id}
     */
    public function destroy(string $id): JsonResponse
    {
        $lead = Lead::where('lead_id', $id)->firstOrFail();
        $lead->delete();

        return response()->json(['message' => 'Lead deleted.']);
    }
}
