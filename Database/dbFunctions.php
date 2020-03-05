<?php 

	require_once('../rabbitmqphp_example/path.inc');
	require_once('../rabbitmqphp_example/get_host_info.inc');
	require_once('../rabbitmqphp_example/rabbitMQLib.inc'); 
	require_once('rabbitMQClient.php'); 
	require('dbConnection.php'); 
	
	error_reporting(E_ALL); 
	
	ini_set('display_errors', 'off'); 
	ini_set('log_errors', 'on'); 
	
	
	function doLogin($username, $password){
		
		$connection = dbConnection(); 
		
		$query = "SELECT * FROM users WHERE username = '$username'";
		$result = $connection->query($query);
		if($result){
			if($result->num_rows == 0){
				return false;
			}else{
				while ($row = $result->fetch_assoc()){
					$salt = $row['salt'];
					$h_password = hashPassword($password, $salt);
					if ($row['h_password'] == $h_password){
						return true; 
					}else{
						return false;
					}
				}
			}
		}
	}
	
	function checkUsername($username){
	
		$connection = dbConnection();
		
		$check_username = "SELECT * FROM users WHERE username = '$username'";
		$check_result = $connection->query($check_username);
		
		if($check_result){
			if($check_result->num_rows == 0){
				return true;
			}elseif($check_result->num_rows == 1){
				return false;
				}
	}
}

function checkEmail($email){
	
	$connection = dbConnection();
	
	$check_email = "SELECT * FROM user WHERE email = '$email' "; 
	$check_result = $connection->query($check_email); 
	
	if($check_result){
		if($check_result->num_rows == 0){
			return true; 
		}elseif($check_result->num_rows == 1){
			return false; 
		}
	}
}

function get_credentials($email){
	
	$connection = dbConnection();
	
	$credentials_query = "SELECT username FROM user WHERE email = '$email'";
	$credentials_query_result = $connection->query($credentials_query);
	
	$row = $credentials_query_result->fetch_assoc(); 
	$user = $row['username']; 
	return $user; 
}

	?>
		
