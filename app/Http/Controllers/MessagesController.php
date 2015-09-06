<?php

namespace App\Http\Controllers;

use App\Message;
use App\Messageboard;
use App\Http\Requests;
use GuzzleHttp\Client;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{

    public function createNewBoard()
    {
        $title = $_POST['title'];
        $ip = $_POST['ip'];
        $id = '';
        try{
            $newBoard = Messageboard::create([
                'title' => $title,
                'creator_ip' => $ip
            ]);
            $id = $newBoard->id;
        }
        catch (QueryException $probablyAlreadyExists) {
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
        if ($msg == '/cat') {
            $msg = $this->_catFacts();
            if ($msg != false) {
                Message::create([
                    'message' => $msg,
                    'author_ip' => 'CatFacts',
                    'board_id' => $board_id
                ]);
            } else {
                Message::create([
                    'message' => 'grumpy cat says NO',
                    'author_ip' => 'CatFacts',
                    'board_id' => $board_id
                ]);
            }
        } else {
            if (!is_null($msg) && trim($msg) != "") {
                Message::create([
                    'message' => $msg,
                    'author_ip' => $ip,
                    'board_id' => $board_id
                ]);
            }
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
            $boards[] = [
                'id' => $board->id,
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

    private function _catFacts()
    {
        $request = new Client();
        $response = $request->get('http://catfacts-api.appspot.com/api/facts?number=1');
        $carfax = json_decode($response->getBody()->read(1000));
        if ($carfax->success == true) {
            return $carfax->facts['0'];
        } else {
            return false;
        }
    }
}
