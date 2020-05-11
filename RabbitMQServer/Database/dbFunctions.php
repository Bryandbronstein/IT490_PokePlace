
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
			}//else{
			//	while ($row = $result->fetch_assoc()){
				//	$salt = $row['salt'];
				//	$h_password = hashPassword($password, $salt);
				//	if ($row['h_password'] == $h_password){
				//		return true;
				//	}else{
				//		return false;
				//	}
			//	}
		}
		$response = true;
		return $response;
		var_dump($response);
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

	$check_email = "SELECT * FROM users WHERE email = '$email' ";
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

	$credentials_query = "SELECT username FROM users WHERE email = '$email'";
	$credentials_query_result = $connection->query($credentials_query);

	$row = $credentials_query_result->fetch_assoc();
	$user = $row['username'];
	return $user;
}

function register($username, $email, $password, $firstname, $lastname){

	$connection = dbConnection();

//	$salt = randomString(29);

//	$h_password = hashPassword($password, $salt);

	$newuser_query = "INSERT INTO users (username, email, firstname, lastname, password) VALUES ('$username', '$email', '$firstname', '$lastname', '$password')";
	
	$leaderboard_query = "INSERT INTO leaderboard(username, wins, losses) 
		VALUES('$username', 0, 0)"; 

	$result = $connection->query($newuser_query);
	var_dump($result);
	$result2 = $connection->query($leaderboard_query); 

	return true;
}


function LoadCategories(){

	$connection = dbConnection();

	$sql = "SELECT * FROM categories";

	$result = mysqli_query($connection,$sql);

	if(!$result)
	{
		echo 'The categories could not be displayed, please try again later.';
	}
	else
	{
		if(mysqli_num_rows($result) == 0)
		{
			echo 'No categories defined yet.';
		}
		else
		{

		   $tempString = "";
		   $tempString.= '<table class="table table-hover table-dark">';
		   $tempString.= '<thead>';
		   $tempString.='<tr>';
		   $tempString.='<th colspan="6"><span class="tableTitle">Categories</span></th>';
		   $tempString.='</tr>';
		   $tempString.='</thead>';
		   $tempString.='<tbody>';

			while($row = mysqli_fetch_assoc($result))
			{

			   $tempString.= '<tr>';
			   $tempString.= '<td><a href="category.php?id=' . $row['cat_id'] . '"><span class="categoryTitle">' . $row['cat_name'] . '</span></a></td>';
			   $tempString.= '<td>' . $row['cat_description'] . '</td>';
			   $tempString.= '</tr>';

			}
		    $tempString.= '</tbody>';
       		    $tempString.= '</table>';

		    return $tempString;
		}
	}
    
}

function LoadTopics($cat_id){

	$connection = dbConnection();

	$sql = "SELECT * FROM topics WHERE topic_cat = '$cat_id'";

	$result = mysqli_query($connection,$sql);

	if(!$result)
	{
		echo 'The topics for this category could not be displayed, please try again later.';
	}
	else
	{
		if(mysqli_num_rows($result) == 0)
		{
			echo 'No topics defined yet.';
		}
		else
		{
		$tempString = "";
		$tempString.= '<table border="1"><table class="table table-hover table-dark">';
           	$tempString.= "<thead>";
           	$tempString.= "<tr>";
                $tempString.= '<th><span class="tableTitle">Topics</span></th>';
                $tempString.= '<th><span class="tableTitle">Date posted</span></th>';
           	$tempString.= "</tr>";
          	$tempString.= "</thead>";
	        $tempString.= "<tbody>";

		   while($row = mysqli_fetch_assoc($result)){
		       $tempString.= '<tr>';
		       $tempString.= '<td><a href="topic.php?id=' . $row['topic_id'] . '"><span class="categoryTitle">' . $row['topic_subject'] . '</span></a></td>';
		       $tempString.= '<td>' . $row['topic_date'] . '</td>';
		       $tempString.= "</tr>";
		   }

           	$tempString.= "</tbody>";
       	        $tempString.= "</table>";


		return $tempString;
		}
	}

    
}

function LoadPosts($topic_id){

	$connection = dbConnection();

	$sql = "SELECT * FROM posts WHERE post_topic = '$topic_id'";

	$result = mysqli_query($connection,$sql);
	$resultArray = mysqli_fetch_assoc($result);
	$userid = $resultArray['post_by'];

	$sqlusername = "SELECT username FROM users WHERE id = '$userid'";
	$results = $connection->query($sqlusername);
	$userAssoc = mysqli_fetch_assoc($results);
	$username = $userAssoc['username'];

	if(!$result){
		echo 'The posts could not be displayed, please try again later.';
	}
	else{
		if(mysqli_num_rows($result) == 0)
		{
			echo 'No posts defined yet.';
		}
		else{
			$tempString = "";
		    $tempString.= '<table class="table table-hover table-dark">';
		    $tempString.= '<thead>';
		    $tempString.= '<tr>';
		    $tempString.= '<th colspan="6"><span class="tableTitle">Replies</span></th>';
		    $tempString.= '</tr>';
		    $tempString.= '</thead>';
		    $tempString.= '<tbody>';
			while($row = mysqli_fetch_assoc($result)){
			    $tempString.= '<tr>';
			    $tempString.= '<td>Posted by: ' . $username . '</td>';
			    $tempString.= '<td>' . $row['post_content'] . '</td>';
			    $tempString.= '</tr>';
			}
		    $tempString.= '</tbody>';
	            $tempString.= '</table>';

		    return $tempString;
		}
	}
}

function CreateCategories($cat_name, $cat_description){

	$connection = dbConnection();

	$sqlCategory = "INSERT INTO categories(cat_name, cat_description) VALUES('$cat_name', '$cat_description')";

	$result = $connection->query($sqlCategory);

	return true;
}

function CreateTopics($topic_subject, $cat_id, $username){

        $connection = dbConnection();

		$sqluserid = "SELECT id FROM users WHERE username = '$username'";
		$results = $connection->query($sqluserid);
		$userid = mysqli_fetch_array($results);


        $sqlCategory = "INSERT INTO topics(topic_subject, topic_cat, topic_by) VALUES('$topic_subject', '$cat_id', '$userid[0]')";

        $result = $connection->query($sqlCategory);
		var_dump($result);
        return true;
}

function CreatePosts($post_content, $topic_id, $username){

	$connection = dbConnection();

	$sqluserid = "SELECT id FROM users WHERE username = '$username'";
	$results = $connection->query($sqluserid);
	$userid = mysqli_fetch_array($results);


	$sqlPost = "INSERT INTO posts(post_content, post_topic, post_by) VALUES('$post_content', '$topic_id', '$userid[0]')";
	$result = $connection->query($sqlPost);

	return true;
}

function parseSearch($search_json){
	        $connection = dbConnection();

	
	$pokemonReturned = json_decode($search_json);
	$pokemonList = $pokemonReturned -> pokemonName;

	$tempString = "";
	$tempString .= '<table class="table table-hover table-dark search-results>"';
	$tempString.="	<thead>";
          $tempString.="  <tr>";
            $tempString.=' <th colspan="6"><span class="tableTitle">Search Results</span></th>';
          $tempString.="  </tr>";
           $tempString.=" </thead>";
           $tempString.=" <tbody>";
	   $tempString.=" <tr>";
		
		foreach($pokemonList as $name){
		 
              $tempString.='  <td><a href="pokemon.php?name=' . $name  . '"><span class="categoryTitle">' . $name . '</span></a></td>';
          $tempString.="  </tr>";
	      $tempString.=" <tr>";
		}
           $tempString.=" </tbody>";
	   $tempString.=" </table>";
	   return $tempString;
}


function getPokemon($username){
	        $connection = dbConnection();


	$poke_sql = "SELECT * from users WHERE username = '$username'"; 

	$resultRaw = mysqli_query($connection, $poke_sql);
	$result = mysqli_fetch_assoc($resultRaw);
	var_dump($result); 
	$pokemon_1 = $result['pokemon_1'];
	$pokemon_2 = $result['pokemon_2'];
	$pokemon_3 = $result['pokemon_3'];
	$pokemon_4 = $result['pokemon_4'];
	$pokemon_5 = $result['pokemon_5'];
	$pokemon_6 = $result['pokemon_6'];	

	$tempString= ""; 
         $tempString.= '<table class="table table-hover table-dark">';
            $tempString.= " <thead>";
            $tempString.= " <tr>";
               $tempString.= '  <th><span class="tableTitle">Pokemon #1</span></th>';
               $tempString.= ' <th><span class="tableTitle">Pokemon #2</span></th>';
               $tempString.= ' <th><span class="tableTitle">Pokemon #3</span></th>';
               $tempString.= ' <th><span class="tableTitle">Pokemon #4</span></th>';
               $tempString.= ' <th><span class="tableTitle">Pokemon #5</span></th>';
               $tempString.= ' <th><span class="tableTitle">Pokemon #6</span></th>';
                $tempString.= " </tr>";
            $tempString.= "</thead>";
            $tempString.= "<tbody>";
            $tempString.= " <tr class='text-center'>";
               $tempString.= ' <td>' .$pokemon_1. '</td>';
               $tempString.= ' <td>' .$pokemon_2. '</td>';
               $tempString.= ' <td>' .$pokemon_3. '</td>';
               $tempString.= ' <td>' .$pokemon_4. '</td>';
               $tempString.= ' <td>' .$pokemon_5. '</td>';
               $tempString.= ' <td>' .$pokemon_6. '</td>';
            $tempString.= "</tr>";
            $tempString.= "</tbody>";
	    $tempString.= "</table>"; 
	    return $tempString; 
}

function addPokemon($username, $pokemonName){
	$connection = dbConnection(); 

	$sql = "Select * FROM users WHERE username = '$username'"; 
	
	$resultRaw = mysqli_query($connection, $sql);
        $result = mysqli_fetch_assoc($resultRaw);
	var_dump($pokemonName);
	if($result['pokemon_1' ]){
		if($result['pokemon_2']){
			if($result['pokemon_3']){
				if($result['pokemon_4']){
					if($result['pokemon_5']){
						if($result['pokemon_6']){
							return false;
						}else{
							$sql =" UPDATE users SET pokemon_6 = '$pokemonName' WHERE username = '$username'";

							
						} 
					}else{
						$sql = "UPDATE users SET pokemon_5 = '$pokemonName' WHERE username = '$username'";

						
					}
				}else{
					$sql = "UPDATE users SET pokemon_4 = '$pokemonName' WHERE username = '$username'";

					
				}
			}else{
				$sql = "UPDATE users SET pokemon_3 = 'clefairy' WHERE username = 'bob'";

				
			}
			
		}else{
			$sql = "UPDATE users SET pokemon_2 = '$pokemonName' WHERE username = '$username'";

			
		}

	
	
	}else{
		$sql = "UPDATE users SET pokemon_1 = '$pokemonName' WHERE username = '$username'";

 
		 
	}
	$resultRaw = mysqli_query($connection, $sql);
	return true; 
}

function battle($username_1, $username_2){ 

	$connection = dbConnection();

	$sql = "SELECT * FROM users WHERE username = '$username_1'"; 
	
	$resultRaw = mysqli_query($connection, $sql);
	$username_1 = mysqli_fetch_assoc($resultRaw);

	$sql2 = "SELECT * FROM users WHERE username = '$username_2'";

	$resultRaw = mysqli_query($connection, $sql2);
    $username_2 = mysqli_fetch_assoc($resultRaw);



	$request = array();
	$request['type'] = 'Battle';
	$request['username_1'] = $username_1;
	$request['username_2'] = $username_2;



	return $request;

}

function leaderboard($user1, $user2, $u1R, $u2R){ 
	$connection = dbConnection();

	if($u1R == 0){
		$sql = "UPDATE leaderboard SET losses = losses +1 WHERE username = '$user1'";
		$sql2 = "UPDATE leaderboard SET wins = wins +1 WHERE username = '$user2'";

		$resultRaw = mysqli_query($connection, $sql);
		$resultRaw2 = mysqli_query($connection, $sql2);
		return 0;
	}
	else{
				$sql = "UPDATE leaderboard SET losses = losses +1 WHERE username = '$user2'";
                $sql2 = "UPDATE leaderboard SET wins = wins +1 WHERE username = '$user1'";

                $resultRaw = mysqli_query($connection, $sql);
				$resultRaw2 = mysqli_query($connection, $sql2);
				return 1;
	}



}	

function loadLeaderboard()
{
	$connection = dbConnection();

	$sql = "SELECT * FROM leaderboard ORDER BY wins DESC";


	$result = mysqli_query($connection, $sql);


	if (!$result) {
		echo 'The categories could not be displayed, please try again later.';
	} else {
		if (mysqli_num_rows($result) == 0) {
			echo 'No categories defined yet.';
		} else {
			$tempString = "";
			$tempString .= '<table class="table table-hover table-dark">';
			$tempString .= " <thead>";
			$tempString .= " <tr>";
			$tempString .= ' <th><span class="tableTitle">Rank</span></th>';
			$tempString .= ' <th><span class="tableTitle">Username</span></th>';
			$tempString .= '<th><span class="tableTitle">Wins</span></th>';
			$tempString .= '<th><span class="tableTitle">Losses</span></th>';
			$tempString .= '</tr>';
			$tempString .= '</thead>';
			$tempString .= '<tbody>';
			$count = 1;
			while ($row = mysqli_fetch_assoc($result)) {

				$tempString .= '<tr class="text-center">';
				$tempString .= '<td>' . $count . '</td>';
				$tempString .= '<td>' . $row['username'] . '</td>';
				$tempString .= '<td>' . $row['wins'] . '</td>';
				$tempString .= '<td>' . $row['losses'] . '</td>';
				$tempString .= " </tr>";
				$count++;
			}
			$tempString .= "</tbody>";
			$tempString .= "</table>";

			return $tempString;
		}
	}
}

function LoadUsers(){

        $connection = dbConnection();

        $sql = "SELECT username FROM users";

        $result = mysqli_query($connection,$sql);
        $resultArray = array();
        while( $Row = mysqli_fetch_assoc($result))

        {
                $resultArray[] = $Row;

        }


        $resultjson = json_encode($resultArray);
        var_dump($resultjson);
        var_dump($resultArray);
        return $resultjson;


}



function addFriends($username, $friendToAdd){

    $connection = dbConnection();

    $sql = "SELECT * FROM users WHERE username = '$username'";

    $resultRaw = mysqli_query($connection, $sql);
    $result = mysqli_fetch_assoc($resultRaw);
    var_dump($username);
    if($result['friend1']) {
        if ($result['friend2']) {
            return false;
        } else {
            $sqlUpdate = "UPDATE users SET friend2 = '$friendToAdd' WHERE username = '$username'";
        }
    }else{
        $sqlUpdate = "UPDATE users SET friend1 = '$friendToAdd' WHERE username = '$username'";
    }
        $resultRawUpdate = mysqli_query($connection, $sqlUpdate);

	 return true;
}


function LoadFriends($username){

        $connection = dbConnection();

        $sql = "SELECT * FROM users WHERE username = '$username'";

        $result = mysqli_query($connection, $sql);
        $resultArray = mysqli_fetch_assoc($result);
        $newResult = array();
        $newResult['friend1'] = $resultArray['friend1'];
        $newResult['friend2'] = $resultArray['friend2'];
        $jsonResult = json_encode($newResult);
        var_dump($jsonResult, $newResult);
        return $jsonResult;


        }

?>
