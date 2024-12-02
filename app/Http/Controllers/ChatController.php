<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user_id; // Obtén el ID del usuario desde la solicitud

        // Verificamos si el user_id está presente
        if (!$userId) {
            return response()->json(['error' => 'user_id is required'], 400);
        }

        // Filtramos las conversaciones donde el usuario es propietario o interesado
        $chats = Chat::where(function($query) use ($userId) {
            $query->where('user_owner_id', $userId)
                ->orWhere('user_interested_id', $userId);
        })->get();

        return response()->json($chats);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:productos,id',
            'user_owner_id' => 'required|exists:users,id',
            'user_interested_id' => 'required|exists:users,id',
        ]);

        $chat = Chat::create($validated);

        return response()->json($chat, 201);
    }

    public function show($id)
    {
        $chat = Chat::findOrFail($id);
        return response()->json($chat);
    }

    public function update(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'sometimes|exists:products,id',
            'user_owner_id' => 'sometimes|exists:users,id',
            'user_interested_id' => 'sometimes|exists:users,id',
        ]);

        $chat->update($validated);

        return response()->json($chat);
    }

    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();

        return response()->json(['message' => 'Chat deleted successfully']);
    }
}
