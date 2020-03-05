<?php 

	function dbConnection(){
	
		$hostname = '127.0.0.1'; 
		$user = 'aa2427'; 
		$pass = '1Amadors'; 
		$dbname = 'registration'; 
		
		$connection = mysqli_connect($hostname, $user, $pass, $dbname);  
		
		if (!$connection){
			echo "Error connecting to database: ".$connection->connect_errno.PHP_EOL; 
			exit(1); 
			}
			echo "Connection made to database".PHP_EOL; 
			return $connection; 
		} 
		
?>
