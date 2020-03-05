<?php

        require_once('../rabbitmqphp_example/path.inc');
        require_once('../rabbitmqphp_example/get_host_info.inc');
        require_once('../rabbitmqphp_example/rabbitMQLib.inc');

        require_once('dbFunctions.php');

        error_reporting(E_ALL);
        ini_set('display_errors', 'on');
        ini_set('log_errors', 'on');

        function requestProcessor($request){
                echo "received request".PHP_EOL;
                echo $request['type'];
                var_dump($request);

                if(!isset($request['type'])){
                        return array('message'=>"ERROR: Message not found");
                }
                switch($request['type']){

                case "test":
                        $response_msg = "Hello World";
                        break;
                }
	echo $response_msg;
                return $response_msg;
        }

        $server = new rabbitMQServer('../rabbitmqphp_example/dbWeb.ini', 'testServer');

        $server->process_requests('requestProcessor');

?>

