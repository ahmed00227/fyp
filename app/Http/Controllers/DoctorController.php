<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Chat;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Event\MessageEvent;

class DoctorController extends Controller
{
    public function index(){
        $chats= Chat::where(function ($query) {
            $query->where('user1_id',auth()->id())->orWhere('user2_id',auth()->id());
        })->get();
        return view('doctor.index',compact('chats'));
    }
    public function chat($id){
        $chat= Chat::findOrFail($id);
        return view('doctor.chat',compact('chat'));
    }
    public function messageSend(MessageRequest $request,$chatId)
    {
        $chat=Chat::find($chatId);
        $message=$chat->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);
        event(new \App\Events\Chat($chatId,$message,auth()->user()));
        return response()->json(['success' => true,'message' => $message]);
    }
}
