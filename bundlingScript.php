<?php

function bundleFiles(){
    //CREATES A .tar ARCHIVE
    $a = new PharData('../directoryToBuild/frontendBundle.tar');

    //ADDS FILES TO THE ARCHIVE FROM A SPECIFIED FOLDER
    $a->buildFromDirectory('../directoryToBuild');

    // COMPRESS THE .tar FILE
    $a->compress(Phar::GZ);

    //MOVES THE .tar.gz ARCHIVE FROM "directoryToBuild" TO "directoryToSend"
    rename('../directoryToBuild/frontendBundle.tar.gz', '../directoryToSend/frontendBundle.tar.gz');

    //DELETES ALL FILE COPIES IN "directoryToBuild"
    $files = glob('../directoryToBuild/*');
    foreach($files as $file){
        if(is_file($file))
            unlink($file);
    }

    //VAR DUMPS A LIST OF ALL FILES IN "directoryToSend" FOR ERROR CHECKING
    $files = scandir('../directoryToSend');
    var_dump($files);

    //CREATES REQUEST TO SEND TO DEPLOYMENT SERVER LISTENER
    $request = array();
    $request['type'] = "frontend";

    //SENDS REQUEST THEN ECHOS RESPONSE FROM THE DEPLOYMENT SERVER
    $response = createClientRequest($request);
    echo $response;


    //CODE FOR RMQ REQUEST
    function createClientRequest($request){
        $client = new rabbitMQClient("/home/ubuntu/git/IT490_PokePlace/rabbitmqphp_example/rabbitMQ_db.ini", "testServer");
        $response = $client->send_request($request);

        return $response;
    }

}
