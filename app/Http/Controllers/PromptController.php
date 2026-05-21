<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Prompt;

class PromptController extends Controller
{

    public function generateGuest(Request $request)
    {
        if (session('guest_used')) {
            return response()->json(['error' => 'Free trial already used. Please login to continue.'], 403);
        }

        $request->validate([
            'topic' => 'required|string|max:500',
            'style' => 'required|string'
        ]);

        $result = $this->callAI($request->topic, $request->style);

        if (!$result) {
            return response()->json(['error' => 'AI request failed. Please try again.']);
        }

        session(['guest_used' => true]);

        return response()->json(['prompt' => $result]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:1000',
            'style' => 'required|string'
        ]);

        $promptText = $this->callAI($request->topic, $request->style);

        if (!$promptText) {
            return response()->json(['prompt' => 'AI request failed']);
        }

        Prompt::create(['user_id' => auth()->id(), 'content' => $promptText]);

        return response()->json(['prompt' => $promptText]);
    }

    private function callAI(string $topic, string $style): ?string
    {
        $instruction = "You are a professional AI prompt engineer.\n\nUser idea: {$topic}\n\nTask: Generate a high quality {$style} AI prompt.\n\nRules:\n- Detect the user's language automatically.\n- Respond using the SAME language as the user input.\n- Improve the user's idea into a clear and powerful AI prompt.\n- Return only the final prompt.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'Content-Type'  => 'application/json',
            'HTTP-Referer'  => config('app.url'),
            'X-Title'       => 'PromptForge'
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model'    => env('OPENROUTER_MODEL'),
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert prompt engineer.'],
                ['role' => 'user',   'content' => $instruction]
            ],
            'temperature' => 0.8,
            'max_tokens'  => 500
        ]);

        if (!$response->successful()) return null;

        return $response->json()['choices'][0]['message']['content'] ?? null;
    }

}