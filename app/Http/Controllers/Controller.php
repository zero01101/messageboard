<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkForSpecialMessage($message)
    {
        switch ($message) {
            case '/cat':
                $request = new Client();
                $response = $request->get('http://catfacts-api.appspot.com/api/facts?number=1');
                $carfax = json_decode($response->getBody()->read(1000));
                if ($carfax->success == true) {
                    return [
                        'msg' => $carfax->facts['0'],
                        'ip'  => 'CatFacts'
                    ];
                } else {
                    return [
                        'msg' => 'grumpy cat says NO :(',
                        'ip'  => 'CatFacts'
                    ];
                }
            default:
                return $message;
        }
    }
}


