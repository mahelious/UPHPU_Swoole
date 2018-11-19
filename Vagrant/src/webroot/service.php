<?php

$bind_ip = '0.0.0.0';

$http = new swoole_http_server($bind_ip, 9501);

$http->on("start", function ($server) use($bind_ip) {
    echo "Swoole http server is started at http://$bind_ip:9501\n";
});

$http->on("request", function ($request, $response) {
    $response->header("Content-Type", "text/plain");
    $response->end("Hello World\n");
});

$http->start();

/*
// Create the server object and listen 127.0.0.1:9501
$server = new swoole_server("127.0.0.1", 9501);

// Register the function for the event `connect`
$server->on('connect', function($server, $fd) {
    echo "Client : Connect.\n";
});

// Register the function for the event `receive`
$server->on('receive', function($server, $fd, $from_id, $data) {
    $server->send($fd, "Server: " . $data);
});

// Register the function for the event `close`
$server->on('close', function($server, $fd) {
    echo "Client: {$fd} close.\n";
});

// Start the server
$server->start();
*/

