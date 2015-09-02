<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Message;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    public function postMessage()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        return view('post')->with('ip', $ip);
    }

    public function processPostMessage()
    {
        $ip = $_POST['ip'];
        $msg = trim($_POST['msg']);
        if (!is_null($msg) && $msg != "") {
            Message::create(['message' => $msg, 'author_ip' => $ip]);
            return redirect('view');
        } else {
            return redirect('view');
        }
    }

    public function showMessages()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $messages = Message::latest('created_at')->limit(100)->get();
        return view('view')->with('messages', $messages)->with('ip', $ip);
    }
}
