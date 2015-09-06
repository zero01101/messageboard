<?php

namespace App\Http\Controllers;

use App\Message;
use App\Messageboard;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class MessagesController extends Controller
{

    public function createNewBoard()
    {
        $title = $_POST['title'];
        $ip = $_POST['ip'];
        $id = '';
        try {
            $newBoard = Messageboard::create([
                'title'      => $title,
                'creator_ip' => $ip
            ]);
            $id = $newBoard->id;
        } catch (QueryException $probablyAlreadyExists) {
            $welp = Messageboard::all()
                ->where('title', $title);
            foreach ($welp as $oh) {
                $id = $oh->id;
            }
        }

        return redirect('view/' . $id);
    }

    public function postMessage($board_id = null)
    {
        $board_id == null ? $board_id = 1 : $board_id;
        $messages = Message::latest('created_at')
            ->where('board_id', $board_id)
            ->limit(5)
            ->get();
        $ip = $_SERVER['REMOTE_ADDR'];

        return view('post')->with('ip', $ip)
            ->with('messages', $messages)
            ->with('board_id', $board_id);
    }

    public function processPostMessage()
    {
        $ip = $_POST['ip'];
        if ($_POST['_current_board'] == $_POST['board_id']) {
            $board_id = $_POST['_current_board'];
        } else {
            $board_id = $_POST['board_id'];
        };

        $msg = trim($_POST['msg']);
        $msg = $this->checkForSpecialMessage($msg);
        if (is_array($msg)) {
            $ip = $msg['ip'];
            $msg = $msg['msg'];
        }
        if (!is_null($msg) && trim($msg) != "") {
            Message::create([
                'message'   => $msg,
                'author_ip' => $ip,
                'board_id'  => $board_id
            ]);
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
        foreach ($boardsCollection as $board) {
            $boards[] = [
                'id'    => $board->id,
                'title' => $board->title
            ];
            if ($board->id == $board_id) {
                $title = $board->title;
            }
        }
        $messages = Message::latest('created_at')
            ->where('board_id', $board_id)
            ->limit(25)
            ->get();

        return view('view')->with('messages', $messages)
            ->with('ip', $ip)
            ->with('boards', $boards)
            ->with('title', $title)
            ->with('board_id', $board_id);
    }
}
