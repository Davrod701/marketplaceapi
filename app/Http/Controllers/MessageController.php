<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index($chatId)
    {
        // Obtener todos los mensajes de una conversación específica
        $messages = Message::where('chat_id', $chatId)->get();
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'sender_id' => 'required|exists:users,id',
            'message' => 'required|string|max:255',
        ]);

        $message = Message::create($validated);

        return response()->json($message, 201);
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        return response()->json($message);
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        $validated = $request->validate([
            'message' => 'sometimes|string|max:255',
        ]);

        $message->update($validated);

        return response()->json($message);
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return response()->json(['message' => 'Message deleted successfully']);
    }
}
