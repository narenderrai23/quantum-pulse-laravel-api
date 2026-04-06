<?php

namespace App\Http\Controllers;

use App\Ai\Agents\ChatAgent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * POST /api/chat
     * Handles the AI lead-collection chat flow via ChatAgent.
     *
     * Request body:
     *   history: [{ role: 'user'|'model', content: string }]
     *   message: string
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message'           => 'required|string',
            'history'           => 'array',
            'history.*.role'    => 'required|in:user,model',
            'history.*.content' => 'required|string',
        ]);

        // Normalize 'model' role to 'assistant' for the SDK
        $history = array_map(function ($msg) {
            return [
                'role'    => $msg['role'] === 'model' ? 'assistant' : $msg['role'],
                'content' => $msg['content'],
            ];
        }, $request->history ?? []);

        try {
            $response = (new ChatAgent($history))->prompt($request->message);

            return response()->json(['reply' => $response->text]);
        } catch (\Laravel\Ai\Exceptions\RateLimitedException $e) {
            return response()->json([
                'reply' => "I'm experiencing high demand right now. Please try again in a few moments!",
            ], 200);
        } catch (\Throwable $e) {
            if (str_contains($e->getMessage(), '429') || str_contains($e->getMessage(), 'quota') || str_contains($e->getMessage(), 'rate')) {
                return response()->json([
                    'reply' => "I'm experiencing high demand right now. Please try again in a few moments!",
                ], 200);
            }
            return response()->json(['error' => 'AI service unavailable.', 'detail' => $e->getMessage()], 502);
        }
    }
}
