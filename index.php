<?php
require __DIR__. "/vendor/autoload.php";

use Amp\Promise;
use function Amp\ParallelFunctions\parallelMap;
use App\Functions\Api;

$start = time();

Amp\Loop::run(function() {

    $users = Amp\Promise\wait(
        Api::call("https://jsonplaceholder.typicode.com/users")
    );

    $promises = Promise\wait(
        parallelMap($users, function ($user) {   
            return Api::call("https://jsonplaceholder.typicode.com/users/{$user->id}/todos");
        })
    );

    foreach ( $promises as $responses ) {
        if(is_array($responses))
        {
            foreach($responses as $response)
            {
                echo $response->title . PHP_EOL;   
            }
        }
    } 

});

$end = time();

echo 'Time execution: '. ($end - $start) . ' seconds'; 
