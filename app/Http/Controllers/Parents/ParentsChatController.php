<?php

namespace App\Http\Controllers\Parents;

use App\ChatMessage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParentsChatController extends Controller
{
    public function index()
    {
        //fetch previous chats
        $chatMsgs = [];
        $parent_id = session()->get('parent_auth')->id;

        $sent_messages = ChatMessage::where([
            'sender_id' => $parent_id,
            'sender_type' => 'parent'
        ])->get();
        $received_msgs = ChatMessage::where([
            'recipient_id' => $parent_id,
            'recipient_type' => 'parent'
        ])->get();
        $messages = $sent_messages->merge($received_msgs);
        $messages  = $messages->sortBy(function($msg){ return $msg->created_at; });
        foreach ($messages as $message) {
            $chatMsgs[] = $message->messageArray();
        }

        return view('parents.chat')->with([
            'messages' => $chatMsgs
        ]);
    }

    public function sendMsg(Request $request)
    {
        $validation = $request->validate([
            'message' => 'required',
        ], [
            'message.required' => "Please enter the message",
        ]);

        if(is_null($request['chat_id'])){
            $request['chat_id'] = str_random(5);
        }

        //admin is sending message
        $message = ChatMessage::create([
            'chat_id' => $request['chat_id'],
            'message' => $request['message']
        ]);

        //save logged in parent as send
        session()->get('parent_auth')->addSender($message);

        //save parent as recipient
        $admin = User::first();
        $admin->addRecipient($message);

        session()->flash('success', "Successfully sent message");
        return redirect()->route('parents_chat');
    }
}
