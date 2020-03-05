

<?php
//Required Files
require_once('/home/helder/rabbitmqphp_example/path.inc');
require_once('/home/helder/rabbitmqphp_example/get_host_info.inc');
require_once('/home/helder/rabbitmqphp_example/rabbitMQLib.inc');


//function for storing errors
function storeError($error, $fileName){
        $fp = fopen( $fileName . '.txt', "a" );
        for ($i = 0; $i < count($error); $i++){
          fwrite( $fp, $error[$i] );
        }
        return true;
    }


//this will route request from server to function
function requestProcessor($request){
	echo "request Recieved".PHP_EOL;
	echo $request ['type'];

	//This will show all request coming in
	var_dump ($request);
	
	if(!isset($request['type'])){
		return array('message'=>"Error: Message not supported");
	}
	Switch($request['type']){

	  case "test":
		echo "<br>In DMZ listener: ";
		$response_msg = storeError($request['error_string'], 'dmz_errors');
		echo "Result: " .$response_msg;
		break;
	case "db":
		echo"<br>In Database listener: ";
		$response_msg = storeError($request['error_string'], 'db_errors');
		echo "Result: " .$response_msg;
		break;

	case "Register":
		echo "<br> In Client Listner: ";
		$response_msg = storeError($request['error_string'], 'client_errors');
		echo "Result: " .$response_msg;
		break;

	}
	
	echo $response_msg;
	return $response_msg;
}

//creating new server
$server = new rabbitMQServer('/home/helder/rabbitmqphp_example/rabbitMQ_rmq.ini', 'testServer');

//processes the request sent by client
$server->process_requests('requestProcessor');

?>
