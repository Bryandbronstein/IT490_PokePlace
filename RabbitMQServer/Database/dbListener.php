<?php

	require_once('../rabbitmqphp_example/path.inc');
	require_once('../rabbitmqphp_example/get_host_info.inc');
	require_once('../rabbitmqphp_example/rabbitMQLib.inc');

	require_once('../rabbitmqphp_example/dbFunctions.php');

	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	ini_set('log_errors', 'on');

	function requestProcessor($request){
		echo "received request".PHP_EOL;
		echo $request['type'];
		var_dump($request);
		$response_msg = "";

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

		case "CreateTopic":
                        echo "<br>in Create Topics";
                        $response_msg = CreateTopics($request['topic_subject'], $request['cat_id'], $request['username']);
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
			$response_msg =createClientRequest($request);
			//$uncashed_data =createClientRequest($request);
			//$response_msg = cacheData($uncashed_data);
			break;
		 
		case "LoadPokemon":
			$response_msg = getPokemon($request['username']); 
			break;

		case "AddPokemon":
			$response_msg = addPokemon($request['username'], $request['pokemonName']); 
			break; 	
		 

		case "Battle":
			//query db with user 1 to get their pokemon - like you would if you load thier profile
				//store that pokemonlist into an array called $arr1
			//do same thing with user 2
				//store in $arr2


			//modificy method call below - with arr1, arr2
			$dmzRequest = battle($request['username_1'], $request['username_2']);
			$recieve_json = createClientRequest($dmzRequest);
			$response_json = json_decode($recieve_json);
			$user1_result = $response_json -> user1;
			$user2_result = $response_json -> user2;
			echo $user1_result . ' user 1 resultd';
			echo $user2_result . 'user 2 resultd';
		
			$response_msg = leaderboard($request['username_1'], $request['username_2'], $user1_result, $user2_result);
				
			break; 

		case "LoadLeaderboard":

			$response_msg = loadLeaderboard();


			break;

		case "test":
			echo "about to rtn";
			$response_msg = "in case";
			break; 
				
		case "LoadUsers":

                        $response_msg = LoadUsers();


                        break;

                 case "LoadFriends":

                        $response_msg = LoadFriends($request['username']);


                        break;

                 case "AddFriends":

                        $response_msg = addFriends($request['username'], $request['friendToAdd']);


                        break;





		//return $response_msg;
		}
		echo $response_msg;
		return $response_msg;
	}

	$server = new rabbitMQServer('../rabbitmqphp_example/rabbitMQ_db.ini', 'testServer');

	$server->process_requests('requestProcessor');

	function createClientRequest($request)
	{
		$client = new rabbitMQClient("/home/aa2427/git/rabbitmqphp_example/rabbitMQ_dmz.ini", "testServer");
		$response = $client->send_request($request);

		return $response;
	}
	?>
