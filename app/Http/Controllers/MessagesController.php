<?php

namespace App\Http\Controllers;

use App\Message;
use App\Http\Requests;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    private $_catFacts;

    public function postMessage()
    {
        $messages = Message::latest('created_at')->limit(5)->get();
        $ip = $_SERVER['REMOTE_ADDR'];
        return view('post')->with('ip', $ip)
                            ->with('messages', $messages);
    }

    public function processPostMessage()
    {
        $ip = $_POST['ip'];
        $msg = trim($_POST['msg']);
        if (!is_null($msg) && $msg != "") {
            Message::create(['message' => $msg, 'author_ip' => $ip]);
        }
        return redirect('view');
    }

    public function showMessages($catfact = null)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $messages = Message::latest('created_at')->limit(25)->get();
        if (!empty($_REQUEST)) {
            $request = new Client([
                'base_uri' => 'http://catfacts-api.appspot.com/api/facts',
            ]);
            $response = $request->get('http://catfacts-api.appspot.com/api/facts?number=1');
            $carfax = json_decode($response->getBody()->read(1000));
            if ($carfax->success == true) {
                //$catfact = $carfax->facts['0'];
                Message::create(['message' => $carfax->facts['0'], 'author_ip' => 'CatFacts']);
                return redirect('view')->with('messages', $messages)
                                        ->with('ip', $ip);
            }
        } else {
            return view('view')->with('messages', $messages)
                ->with('ip', $ip);
        }
    }
}
