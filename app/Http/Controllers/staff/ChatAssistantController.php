<?php

namespace App\Http\Controllers\Staff;


use App\Http\Controllers\Controller;
use App\Services\ITChatAssistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatAssistantController extends Controller
{
        public function index()
    {
        return view('staff.chat-assistant');
    }

    public function chat(
        Request $request,
        ITChatAssistant $assistant
    ) {
        $validated = $request->validate([
            'messages' => 'required|array|min:1|max:12',
            'messages.*.role' => 'required|in:user,assistant',
            'messages.*.content' => 'required|string|max:2000',
        ]);

        $messages = array_values(
            array_slice($validated['messages'], -12)
        );

        // Require the conversation to begin with a user message.
        if (($messages[0]['role'] ?? null) !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'Please start a new conversation.',
            ], 422);
        }

        try {
            $result = $assistant->reply($messages);

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (Throwable $e) {
            Log::error('IT Chat Assistant failed', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' =>
                    'The IT assistant is temporarily unavailable.',
            ], 500);
        }
    }
}
