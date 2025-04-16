<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    public function recommendations(Request $request){
        $request->validate([
            'message'=>'required',
        ]);
        return   Http::post(config('services.chatbot.recommendations'), [
            'message' => $request->json('message'),
        ]);
    }
    public function descriptions(Request $request){
        return   Http::get(config('services.chatbot.descriptions'), [
            'name' => $request->name,
        ]);
    }
}
