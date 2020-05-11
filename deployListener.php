<?php




        require_once("/home/ubuntu/git/IT490_PokePlace/RabbitMQServer/path.inc");
        require_once("/home/ubuntu/git/IT490_PokePlace/RabbitMQServer/get_host_info.inc");
	require_once("/home/ubuntu/git/IT490_PokePlace/RabbitMQServer/rabbitMQLib.inc");

        require_once("/home/ubuntu/git/Deployment/deployConnection.php");

	$files = glob('/home/ubuntu/versions/frontend/*');

	foreach($files as $file){
		if(is_file($file))
			unlink($file);
	}
	$files1 = glob('/home/ubuntu/versions/frontend/*');
	foreach($files1 as $file1){
		if(is_file($file1))
			unlink($file1);
	}

	$files2 = glob('/home/ubuntu/versions/backend/*');
	foreach($files2 as $file2){
		if(is_file($file2))
			unlink($file2);
	}
	$files3 = glob('/home/ubuntu/versions/dmz/*');
	foreach($files3 as $file3){
		if(is_file($file3))
			unlink($file3);
	}

	function deploy_frontend () {
		$connection = deployConnection();

		$filename = "/home/ubuntu/versions/frontend/frontendBundle.tar.gz";
		shell_exec("sudo chmod 777 $filename");
		if (file_exists($filename)){
			echo "frontendbundleexists";

			
			$query="SELECT * FROM goodversion ORDER BY version DESC";
			$result = $connection->query($query);
			$row = $result->fetch_array(MYSQLI_NUM);
			
			$numToIncrement = $row[0];
			$numToIncrement = $numToIncrement + 0.1;
			
			rename('/home/ubuntu/versions/frontend/frontendBundle.tar.gz', '/home/ubuntu/versions/frontend/version' .$numToIncrement. '.tar.gz');
			$output = shell_exec("sshpass -p 'password' scp /home/ubuntu/versions/frontend/* ubuntu@10.0.0.25:/home/ubuntu/filesToInstall");
			$query2="INSERT INTO goodversion VALUES ($numToIncrement)";
			$result2=$connection->query($query2);

		}else{
			echo "The file $filename does not exists";
		}

		$request = array();
		$request['type'] = "install_frontend";
		$response = createClientRequest($request);
		echo "Response from deployment server: ";
		echo $response;

		//$files = glob('/home/ubuntu/versions/frontend/*');
		//foreach($files as $file){
    		//	if(is_file($file))
		//		unlink($file);
		//}
	}

	function deploy_backend ()  {

		$connection = deployConnection();
		$filename = "/home/ubuntu/versions/backend/backendBundle.tar.gz";
		shell_exec("sudo chmod 777 $filename");
		if (file_exists($filename)){


			$query="SELECT * FROM goodversion ORDER BY version DESC";
			$result = $connection->query($query);
			$row = $result->fetch_array(MYSQLI_NUM);

			$numToIncrement = $row[0];
			$numToIncrement = $numToIncrement + 0.1;

			rename('/home/ubuntu/versions/backend/backendBundle.tar.gz', '/home/ubuntu/versions/backend/version' .$numToIncrement. '.tar.gz');
			$output = shell_exec("sshpass -p 'password' scp /home/ubuntu/versions/backend/* ubuntu@10.0.0.203:/home/ubuntu/filesToInstall");
			$query2="INSERT INTO goodversion VALUES ($numToIncrement)";
			$result2=$connection->query($query2);


		}else{
			echo "The file $filename does not exists";
		}

		$request = array();
		$request['type'] = "install_backend";
		$response = createClientRequest($request);
		echo "Response from deployment server: ";
		echo $response;
		// $files = glob('/home/ubuntu/versions/backend/*');
		//foreach($files as $file){
		//	if(is_file($file))
		//		unlink($file);
		//}
	}

	function deploy_dmz ()  {
			
		$connection = deployConnection();

		$filename = "/home/ubuntu/versions/dmz/dmzBundle.tar.gz";
		shell_exec("sudo chmod 777 $filename");
		if (file_exists($filename)){


			$query="SELECT * FROM goodversion ORDER BY version DESC";
			$result = $connection->query($query);
			$row = $result->fetch_array(MYSQLI_NUM);

			$numToIncrement = $row[0];
			$numToIncrement = $numToIncrement + 0.1;

			rename('/home/ubuntu/versions/dmz/dmzBundle.tar.gz', '/home/ubuntu/versions/dmz/version' .$numToIncrement. '.tar.gz');
			 $output = shell_exec("sshpass -p 'password' scp /home/ubuntu/versions/dmz/* ubuntu@10.0.0.97:/home/ubuntu/filesToInstall");
			$query2="INSERT INTO goodversion VALUES ($numToIncrement)";
			$result2=$connection->query($query2);

		}else{
			echo "The file $filename does not exists";
	 	}

		$request = array();
		$request['type'] = "install_dmz";
		$response = createClientRequest($request);
		echo "Response from deployment server: ";
		echo $response;
		 //$files = glob('/home/ubuntu/versions/dmz/*');
		//foreach($files as $file){
		//	if(is_file($file))
		//		unlink($file);
		//}

	}
	function requestProcessor($request){
		echo "received request".PHP_EOL;
		echo $request['type'];
		var_dump($request);
		$response_msg = "";

		if(!isset($request['type'])){
			return array('message'=>"ERROR: Message not found");
		}
		switch($request['type']){

		case "deploy_frontend":
			echo "<br> in frontend";
			$response_msg = deploy_frontend();

			echo "Result: ". $response_msg;
																							                       
		       	break;
		case "deploy_backend":
			echo "<br> in backend";
																													                        $response_msg = deploy_backend();

																													                        echo "Result: ". $response_msg;
																													
																																break;

																													
		case "deploy_dmz":
			echo "<br> in dmz";
			$response_msg = deploy_dmz();

			echo "Result: ". $response_msg;
			break;
		}

		echo $response_msg;
		return $response_msg;
	}
	$server = new rabbitMQServer("/home/ubuntu/git/IT490_PokePlace/RabbitMQServer/deploy.ini","testServer");

	$server->process_requests('requestProcessor');



		    
	       	function createClientRequest($request){
		       	$client = new rabbitMQClient("/home/ubuntu/git/IT490_PokePlace/RabbitMQServer/deploy.ini", "testServer");
		       	$response = $client->send_request($request);

      			return $response;
		}



	exit();


?>
