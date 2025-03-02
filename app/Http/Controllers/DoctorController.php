<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(){
        $chats= Chat::where(function ($query) {
            $query->where('user1_id',auth()->id())->orWhere('user2_id',auth()->id());
        })->get();
        return view('doctor.index',compact('chats'));
    }
    public function show($id){
        $chat= Chat::findOrFail($id);
        return view('doctor.show',compact('chat'));
    }
}
