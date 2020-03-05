<?php 
	require_once('../rabbitmqphp_example/path.inc');
	require_once('../rabbitmqphp_example/get_host_info.inc');
	require_once('../rabbitmqphp_example/rabbitMQLib.inc');
	
	function createClientForDmz($request){
		$client = new rabbitMQClient("../rabbitmqphp_example/rabbitMQ_dmz.ini", "testServer");
		
		if(isset($argv[1])){
			$msg = $argv[1];
		}
		else{
				$msg = "client";
		}
		$response = $client->send_request($request); 
		return $response;
	}
	
?>
