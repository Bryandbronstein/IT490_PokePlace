<?php

	require_once('../rabbitmqphp_example/path.inc');
	require_once('../rabbitmqphp_example/get_host_info.inc');
	require_once('../rabbitmqphp_example/rabbitMQLib.inc');

	require_once('../rabbitmqphp_example/dbFunctions.php');

	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	ini_set('log_errors', 'on');

	function requestProcessor($request){
	/*	echo "received request".PHP_EOL;
		echo $request['type'];
		var_dump($request);
	 */
		if(!isset($request['type'])){
			return array('message'=>"ERROR: Message not found");
		}
		switch($request['type']){

		case "Login":
		       echo "<br>in login";
		       $response_msg = doLogin($request['username'],$request['password']);
		     echo "Result: ". $response_msg;
			break;
		case "CheckUsernamne":
			echo "<br>in Checkusername";
			$response_msg = checkUsername($request['username']);
			echo "Result: ". $response_msg;
			break;

		case "CheckEmail":
			echo "<br>in CheckEmail";
			$response_msg = checkEmail($request['email']);
			break;

		case "SendEmail":
			echo "<br>in CheckEmail";
			$response_msg = sendEmail($request['email']);
			break;

		case "Register":
			echo "<br>in register";
			$response_msg = register($request['username'], $request['email'], $request['password'], $request['firstname'], $request['lastname']);
			break;

		case "LoadCategories":
			echo "<br>in LoadCategories";
			$response_msg = LoadCategories();
			break;

		case "CreateCategories":
                        echo "<br>in Create Categories";
                        $response_msg = CreateCategories($request['cat_name'], $request['cat_description']);
			break;

		case "LoadTopics":
                        echo "<br>in LoadTopics";
                        $response_msg = LoadTopics($request['cat_id']);
			break;

		case "CreateTopics":
                        echo "<br>in Create Topics";
                        $response_msg = CreateTopics($request['topic_subject'], $request['cat_id']);
			break;

		case "LoadPosts":
                        echo "<br>in LoadPosts";
                        $response_msg = LoadPosts($request['topic_id']);
                        break;
		case "CreatePosts":
                        echo "<br>in Create Posts";
                        $response_msg = CreatePosts($request['post_content'], $request['topic_id'], $request['username']);
			break; 
		case "Search": 
		//	echo "<br>in Search"; 
			$search_json =createClientRequest($request);
			$response_msg = parseSearch($search_json);
			break; 
		 
		case "LoadPokemon":
			$response_msg = getPokemon($request['username']); 
			break;

		case "AddPokemon":
			$response_msg = addPokemon($request['username'], $request['pokemonName']); 
			break; 	
		 

		case "Battle":
			$dmzRequest = battle($request['username_1'], $request['username_2']);
			$recieve_json = createClientRequest($dmzRequest);
			$response_json = json_decode($recieve_json);
			$user1_result = $response_json -> user1;
			$user2_result = $response_json -> user2;
		
			$response_msg = leaderboard($request['username_1'], $request['username_2'], $user1_result, $user2_result);	
				
			break; 

		case "LoadLeaderboard":
			echo "find me bitch";
			$response_msg = loadLeaderboard();
		       echo "loader done";	
			$response_msg = "test"; 
			break; 


		var_dump($response_msg);
		return $response_msg;
		}
	}

	$server = new rabbitMQServer('../rabbitmqphp_example/rabbitMQ_db.ini', 'testServer');

	$server->process_requests('requestProcessor');

	function createClientRequest($request){
   		 $client = new rabbitMQClient("../rabbitmqphp_example/rabbitMQ_dmz.ini", "testServer");
   	 $response = $client->send_request($request);

    	return $response;
	}
	?>
