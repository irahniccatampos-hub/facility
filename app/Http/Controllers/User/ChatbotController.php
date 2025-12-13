<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ChatbotController extends Controller
{
    public function index(): View
    {
        return view('user.chat', ['assistantName' => 'IrahKun']);
    }

    public function message(Request $request): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $apiKey = config('services.groq.key');

        if (!$apiKey) {
            return response()->json([
                'reply' => 'IrahKun here. Please set GROQ_API_KEY in your .env to enable live answers. Meanwhile, double-check facility availability and conflicts before booking.',
            ]);
        }

        $payload = [
            'model' => config('services.groq.model', 'llama3-8b-8192'),
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are IrahKun, a helpful assistant for the Facility Reservation System. Be concise and mention conflicts should be checked before confirming bookings.',
                ],
                [
                    'role' => 'user',
                    'content' => $data['message'],
                ],
            ],
            'temperature' => 0.3,
            'max_tokens' => 256,
        ];

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(15)
            ->post(rtrim(config('services.groq.base_uri'), '/').'/chat/completions', $payload);

        if ($response->failed()) {
            $errorMsg = $response->json('error.message') ?? 'Chat service unavailable.';
            return response()->json(['reply' => $errorMsg], 502);
        }

        $reply = $response->json('choices.0.message.content') ?? 'Sorry, I could not respond.';

        return response()->json(['reply' => $reply]);
    }
}
