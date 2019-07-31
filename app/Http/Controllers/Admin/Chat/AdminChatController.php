<?php

namespace App\Http\Controllers\Admin\Chat;

use App\ChatMessage;
use App\DB\Students\StudentParent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AdminChatController extends Controller
{
    public function index()
    {
        //fetch parents
        $parents = StudentParent::all();

        //fetch previous chats

        $chats = [];

        $messages = ChatMessage::all()->groupBy('chat_id');
        foreach ($messages as $chat_id => $conversation) {
            $chatArray = [];
            $parentMsg = $conversation->where('recipient_type', 'parent')->first();
            if(empty($parentMsg)){
                $parentMsg = $conversation->where('sender_type', 'parent')->first();
                $chatArray['parent_name'] = $parentMsg->sender->name;
                $chatArray['parent_id'] = $parentMsg->sender->id;
            }else{
                $chatArray['parent_name'] = $parentMsg->recipient->name;
                $chatArray['parent_id'] = $parentMsg->recipient->id;
            }
            $latestMsg = $conversation->last();
            $chatArray['chat_id'] = $chat_id;
            $chatArray['date'] = Carbon::parse($latestMsg->created_at)->toTimeString();
            $chatArray['messages'] = $conversation->map(function($msg){ return $msg->messageArray(); })->toArray();

            $chats[] = $chatArray;
        }

        return view('admin.chat')->with([
            'parents' => $parents,
            'chats' => $chats
        ]);
    }

    public function sendMsg(Request $request)
    {
        $validation = $request->validate([
            'parent_id' => 'required',
            'message' => 'required',
        ], [
            'parent_id.required' => "Please select the recipient parent",
            'message.required' => "Please enter the message",
        ]);

        //admin is sending message
        $message = ChatMessage::create([
            'chat_id' => str_random(5),
            'message' => $request['message']
        ]);

        //save admin as the sender
        auth()->user()->addSender($message);

        //save parent as recipient
        $parent = StudentParent::find($request['parent_id']);
        $parent->addRecipient($message);

        session()->flash('success', "Successfully started chat");
        return redirect()->route('admin_chat');
    }

    public function sendChatMsg(Request $request)
    {
        $validation = $request->validate([
            'chat_id' => 'required',
            'message' => 'required',
        ], [
            'chat_id.required' => "Please select the chat",
            'message.required' => "Please enter the message",
        ]);

        //admin is sending message
        $message = ChatMessage::create([
            'chat_id' => $request['chat_id'],
            'message' => $request['message']
        ]);

        //save admin as the sender
        auth()->user()->addSender($message);

        //save parent as recipient
        $parent = StudentParent::find($request['recipient_id']);
        $parent->addRecipient($message);

        session()->flash('success', "Successfully sent message");
        return redirect()->route('admin_chat');
    }
}
