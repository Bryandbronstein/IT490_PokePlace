<?php 

require_once('/home/aa2427/git/rabbitmqphp_example/path.inc');
require_once('/home/aa2427/git/rabbitmqphp_example/get_host_info.inc'); 
require_once('/home/aa2427/git/rabbitmqphp_example/rabbitMQLib.inc'); 

function requestProcessor($request){
	echo "Received request".PHP_EOL; 
	echo $request['type'];
	var_dump($request); 

	if (!isset($request['type'])){
		return array('message'=>'Error:message type not set');
	}

	switch($request['type']){

	case "test":
		$rspMessage = "Inside switch case as expected";
		break; 

	}

	echo var_dump($rspMessage); 
	return $rspMessage; 

}

$server = new rabbitMQServer('/home/aa2427/git/rabbitmqphp_example/rabbitMQ_db.ini', 'testServer');

$server->process_requests('requestProcessor'); 

?>
