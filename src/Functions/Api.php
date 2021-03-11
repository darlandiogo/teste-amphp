<?php

namespace App\Functions;

use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Request;

class Api {
    
    static function call($url)
    {
        return \Amp\call(function () use ($url) {
            try {
                
                $client   = HttpClientBuilder::buildDefault();
                $response = yield $client->request(new Request($url));
                $body     = yield $response->getBody()->buffer();
                return json_decode($body);

            } catch (\Exception $e) {
                echo  "Error: " . $e->getMessage();
            }
        });   
    }

    public function __invoke($param) {
        return self::call($param);
    }
}