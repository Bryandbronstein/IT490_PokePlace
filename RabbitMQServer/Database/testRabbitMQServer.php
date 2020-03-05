#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


include('dbConnection.php'); 

function doLogin($username,$password)
{
	global $db;

	$q = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' and password = '$password'"); 

	if (!$q) {printf("ERROR: %s\n", mysqli_error($db));}

	$r = mysqli_num_rows($q); 
	if ($r == 1) {
		echo "Username exists!\n\n";
		return true;
    
	}

	else{
		echo "Sorry username not specified...\n\n"; 
		return false; 
	}
	errorCheck($db); 
}

function doRegister($username, $password, $email) {
	global $db; 

	$q = mysqli_query($db, "SELECT * FROM students WHERE username = '$username'"); 
	$r = mysqli_num_rows($q);
	if ($r == 1) {
		echo "Username exists!"; 
		return "Username already exists! Please try again.";
	}
	else {
		$q = mysqli_query($db, "INSERT INTO students (username, password, email) VALUES ('$username', '$password', '$email'");
		echo "Inserted values successfully!\n\n"; 
		return true; 
	}
	errorCheck($db);
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

function errorCheck($db) {
	if ($db->errno != 0) {
		echo "Couldn't execute query:".PHP_EOL; 
		echo __FILE__.':'.__LINE__.":error: ".$db->error.PHP_EOL; 
		exit(0); 
	}
}

$server = new rabbitMQServer('rabbitMQ_db.ini', 'testServer');


$server->process_requests('requestProcessor');
exit();
?>

