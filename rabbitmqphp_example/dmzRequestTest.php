#!/usr/bin/php
<?php


require_once('/home/aadarsh/Desktop/git/rabbitmqphp_example/path.inc');
require_once('/home/aadarsh/Desktop/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/aadarsh/Desktop/git/rabbitmqphp_example/rabbitMQLib.inc');




$client = new rabbitMQClient("/home/aadarsh/Desktop/git/rabbitmqphp_example/rabbitMQ_rmq.ini","testServer");

$msg = "default test message";

if (isset($argv[1]))
{
  $msg = $argv[1];
}


$request = array();
$request['type'] = "test";
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]. " END".PHP_EOL;   



