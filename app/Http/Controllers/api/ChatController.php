<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Event\MessageEvent;

class ChatController extends Controller
{
    public function chat($specialization)
    {
        $chat = Chat::where(function ($query) use ($specialization) {
            $query->where('user1_id', auth()->id())
                ->whereHas('user2', function ($query) use ($specialization) {
                    $query->where('speciality', Chat::specialists[$specialization]);
                });
        })->orWhere(function ($query) use ($specialization) {
            $query->where('user2_id', auth()->id())
                ->whereHas('user1', function ($query) use ($specialization) {
                    $query->where('speciality', Chat::specialists[$specialization]);
                });
        })->first();
        if (!$chat) {
            $chat = Chat::create([
                'user1_id' => auth()->id(),
                'user2_id' => User::where('speciality', Chat::specialists[$specialization])->first()->id,
                'last_message_at' => now(),
            ]);
        }
        $messages = $chat->messages;
        return response()->json([
            'success' => true,
            'chat' => $chat,
            'messages' => $messages
        ]);
    }
    public function messageSend(MessageRequest $request)
    {
        $chat = Chat::find($request->chat_id);
        $message = $chat->messages()->create([
            'message' => $request->message,
            'user_id' => auth()->id(),
        ]);
        event(new \App\Events\Chat($chat->id,$message,auth()->user()));
        return response()->json([
            'success' => true,
            'chat' => $chat,
            'message' => $message,
            'user' => auth()->user()
        ]);
    }
}
