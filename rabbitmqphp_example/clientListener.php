<?php   
	
require_once('/home/bryan/git/rabbitmqphp_example/path.inc');
require_once('/home/bryan/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/bryan/git/rabbitmqphp_example/rabbitMQLib.inc');

function requestProcessor($request){
	echo "Receieved Request".PHP_EOL;
	echo $request['type'];
	var_dump($request);

	if (!isset($request['type'])){
		return array('message'=>'Error: Message type not set');
	}
	
	switch($request['type']){
		
		case "test";
			$response = "Inside switch case as expected";
			break;
	
	}

	echo var_dump($response);
	return $response;

}


$server = new rabbitMQServer('/home/bryan/git/rabbitmqphp_example/rabbitMQ_client.ini', 'testServer');
$server->process_requests('requestProcessor');


?>
