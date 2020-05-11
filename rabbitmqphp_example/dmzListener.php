<?php

    require_once('/home/ubuntu/git/it490-dmz/path.inc');
    require_once('/home/ubuntu/git/it490-dmz/get_host_info.inc');
    require_once('/home/ubuntu/git/it490-dmz/rabbitMQLib.inc');
    include '/home/ubuntu/git/it490-dmz/pokeApi.php';



    function requestProcessor($request){
        echo "Recieved Request".PHP_EOL;
        echo $request['type'];
        var_dump($request);

        if (!isset($request['type'])){
            return array('message'=>'Error: Message type not set');
        }

        if($request['type'] == "Search") //search for pokemon
        {
            if(($request['pokemonNum'] == "na") && ($request['name'] == "na"))
            { //if true - check type
                if($request['pokeType'] == "na")
                {  //if true - check ability
                    if($request['ability'] == "na")
                    {
                        //something is wrong, shouldn't get this far
                        //may throw an error here?
                        $rspMessage = "No Search Param - Error";
                    }
                    else
                    {
                        //api call with ability
                        $rspMessage = searchAbility($request['ability']);
                    }
                }
                else
                {
                    //api call with type
                    $rspMessage = searchType($request['pokeType']);
                }
            }
            else
            {
                //api call with name/pokedex number
                if($request['pokemonNum'] != "na"){
                    $rspMessage = searchdexName($request['pokemonNum']);
                }
                else{
                    $rspMessage = searchdexName($request['name']);
                }
            }
        }
        elseif($request['type'] == "Battle"){  //battle system
            //info to send to function
            $user1 = $request['username_1'];
            $user2 = $request['username_2'];
            $rspMessage = battleSystem($user1, $user2);
        }
        
        elseif($request['type'] == "test"){
		$rspMessage = "in test";
	}

	//var_dump($rspMessage);  	        
        return $rspMessage;

    }


    $server = new rabbitMQServer('/home/ubuntu/git/it490-dmz/rabbitMQ_db.ini', 'testServer');

    

    $server->process_requests('requestProcessor');

//    $returnedJson = json_decode(testCall());
//    $exampleAb = $returnedJson -> ab;
//    $exampleN = $returnedJson -> n;
    //this works ^ calls the function in pokeApi.php

?>


