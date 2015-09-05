<?php

namespace App\Http\Controllers;

use App\Message;
use App\Messageboard;
use App\Http\Requests;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    public function postMessage($board_id = null)
    {
        $board_id == null ? $board_id = 1 : $board_id;
        $messages = Message::latest('created_at')->where('board_id', $board_id)->limit(5)->get();
        $ip = $_SERVER['REMOTE_ADDR'];
        return view('post')->with('ip', $ip)
                            ->with('messages', $messages)
                            ->with('board_id', $board_id);
    }

    public function processPostMessage()
    {
        $ip = $_POST['ip'];
        $board_id = $_POST['_current_board'];
        $msg = trim($_POST['msg']);
        if (!is_null($msg) && $msg != "") {
            Message::create(['message' => $msg, 'author_ip' => $ip, 'board_id' => $board_id]);
        }
        return redirect('view/' . $board_id);
    }

    public function showMessages($board_id = null)
    {
        $board_id == null ? $board_id = 1 : $board_id; //that's unpleasant to look at :/
        $title = 'MessageBoard!!!!!';
        $ip = $_SERVER['REMOTE_ADDR'];
        $boardsCollection = Messageboard::all();
        $boards = Array();
        foreach ($boardsCollection as $board)
        {
            $boards[] = ['id' => $board->id, 'title' => $board->title];
            if ($board->id == $board_id) {
                $title = $board->title;
            }
        }
        $messages = Message::latest('created_at')->where('board_id', $board_id)->limit(25)->get();
        if ((!empty($_REQUEST)) && ($_REQUEST['cf'] == 'yesplz')) {
            $request = new Client();
            $response = $request->get('http://catfacts-api.appspot.com/api/facts?number=1');
            $carfax = json_decode($response->getBody()->read(1000));
            if ($carfax->success == true) {
                Message::create(['message' => $carfax->facts['0'], 'author_ip' => 'CatFacts']);
                return redirect('view')->with('messages', $messages)
                                        ->with('ip', $ip)
                                        ->with('boards', $boards)
                                        ->with('title', $title)
                                        ->with('board_id', $board_id);
            }
        } else {
            return view('view')->with('messages', $messages)
                ->with('ip', $ip)
                ->with('boards', $boards)
                ->with('title', $title)
                ->with('board_id', $board_id);
        }
    }
}
