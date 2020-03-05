#!/usr/bin/php
<?php

require_once('/home/aa2427/git/rabbitmqphp_example/path.inc');
require_once('/home/aa2427/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/aa2427/git/rabbitmqphp_example/rabbitMQLib.inc');

$client = new rabbitMQClient("/home/aa2427/git/rabbitmqphp_example/dbtoWeb.ini", "testServer");

$msg = "default test message";

if (isset($argv[1]))
{
        $msg = $argv[1];
}

$request = array();
$request['type'] = "test";
$request['message'] = $msg;
$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]. " END".PHP_EOL;

