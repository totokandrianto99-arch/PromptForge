<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Prompt;

class PromptController extends Controller
{

    public function generate(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:1000',
            'style' => 'required|string'
        ]);

        $topic = $request->topic;
        $style = $request->style;

        $instruction = "
        You are a professional AI prompt engineer.

        User idea: {$topic}

        Task:
        Generate a high quality {$style} AI prompt.

        Rules:
        - Detect the user's language automatically.
        - Respond using the SAME language as the user input.
        - Improve the user's idea into a clear and powerful AI prompt.
        - Return only the final prompt.
        ";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'Content-Type' => 'application/json',
            'HTTP-Referer' => config('app.url'),
            'X-Title' => 'PromptForge'
        ])->post('https://openrouter.ai/api/v1/chat/completions', [

            'model' => env('OPENROUTER_MODEL'),

            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an expert prompt engineer.'
                ],
                [
                    'role' => 'user',
                    'content' => $instruction
                ]
            ],

            'temperature' => 0.8,
            'max_tokens' => 500

        ]);

       if (!$response->successful()) {
    return response()->json([
        'prompt' => 'AI request failed'
    ]);
}

    $promptText = $response->json()['choices'][0]['message']['content'];
        // Simpan ke database
        Prompt::create([
            'user_id' => auth()->id(),
            'content' => $promptText
        ]);

        return response()->json([
            'prompt' => $promptText
        ]);
    }

}