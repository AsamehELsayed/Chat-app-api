<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(StoreMessageRequest $request){
    $data = $request->validated();
    if ($data['receiver_id'] === Auth::id()) {
        return response()->json(['error' => 'cannot send message to yourself'], 403);
    } 
    if (!User::where('id', $data['receiver_id'])->exists()) {
        return response()->json(['error'=> 'receiver does not exist'],0);
    }      
    $message = Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
        'status' => 'sent',
    ]);

    broadcast(new \App\Events\MessageSent($message))->toOthers();

    return response()->json(['message' => 'message sent successfully'], 201);
}
public function getMessages($userId)
{

    $messages = Message::where(function ($query) use ($userId) {
        $query->where('sender_id', Auth::id())
              ->where('receiver_id', $userId);
    })->orWhere(function ($query) use ($userId) {
        $query->where('sender_id', $userId)
              ->where('receiver_id', Auth::id());
    })
      ->paginate(20);

      Message::where('sender_id', $userId)
      ->where('receiver_id', Auth::id())
      ->where('status', 'sent')
      ->update(['status' => 'read']);


    return response()->json($messages);
}

public function markAsRead($messageId)
{
    $message = Message::find($messageId);
    if (!$message) {
        return response()->json(['error' => 'message not found'], 404);
    }
    if ($message->receiver_id !== Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $message->status = 'read';
    $message->save();

    broadcast(new \App\Events\MessageRead($message))->toOthers();

    return response()->json(['message' => 'message marked as read successfully']);
}


}