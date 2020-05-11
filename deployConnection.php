
<?php

function deployConnection(){

	$hostname = '127.0.0.1';
	$user = 'hq33';
	$pass = 'Ass1234!';
	$dbname = 'deploydb';

	$connection = mysqli_connect($hostname, $user, $pass, $dbname);

	if (!$connection){
		echo "Error connecting to database: ".$connection->connect_errno.PHP_EOL;
		exit(1);
	}
	else{
		echo "connected successfully";
	}
//	echo "Connection made to database".PHP_EOL;
                   
	return $connection;               
}
                                                              
?>
