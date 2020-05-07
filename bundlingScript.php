<?php

function bundleFiles(){
    //STEPS TO MAKE THIS SCRIPT WORK
    //1. create empty directories "directoryToBuild" and "directoryToSend"
    //2. Ensure paths to these folders are correct
    //3. any time you see frontend, replace it with the name of your machine (backend, dmz, etc.)

    $a = new PharData('../directoryToBuild/frontendBundle.tar');
    $a->buildFromDirectory('../directoryToBuild');
    $a->compress(Phar::GZ);
    rename('../directoryToBuild/frontendBundle.tar.gz', '../directoryToSend/frontendBundle.tar.gz');

    $files = glob('../directoryToBuild/*');
    foreach($files as $file){
        if(is_file($file))
            unlink($file);
    }

    $output = shell_exec("sudo sshpass -p 'password' scp ../directoryToSend/frontendBundle.tar.gz ubuntu@10.0.0.201:/home/ubuntu/");

    //var dumps for error checking
    $files = scandir('../directoryToSend');
    echo "Var dump of _directoryToSend_ contents: ";
    var_dump($files);
    echo "Var dump of _scp command_ output: ";
    var_dump($output);

    $request = array();
    $request['type'] = "frontend";

    $response = createClientRequest($request);
    echo "Response from deployment server: ";
    echo $response;


    //CODE FOR RMQ REQUEST
    function createClientRequest($request){
        $client = new rabbitMQClient("/home/ubuntu/git/IT490_PokePlace/rabbitmqphp_example/rabbitMQ_db.ini", "testServer");
        $response = $client->send_request($request);

        return $response;
    }

}
