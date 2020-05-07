<?php
    //STEPS TO MAKE THIS SCRIPT WORK
    //1. Create empty directories "directoryToBuild" and "directoryToSend"
    //2. Set permissions for these directories: "sudo chmod 777 PATH_TO_DIRECTORIES"
    //3. Edit paths within this script to match the paths to the directories you just created
    //4. Any time you see frontend, replace it with the name of your machine (backend, dmz, etc.)

    $a = new PharData('/home/ubuntu/git/IT490_PokePlace/directoryToBuild/frontendBundle.tar');
    $a->buildFromDirectory('/home/ubuntu/git/IT490_PokePlace/directoryToBuild');
    $a->compress(Phar::GZ);
    rename('/home/ubuntu/git/IT490_PokePlace/directoryToBuild/frontendBundle.tar.gz', '/home/ubuntu/git/IT490_PokePlace/directoryToSend/frontendBundle.tar.gz');

    $files = glob('/home/ubuntu/git/IT490_PokePlace/directoryToBuild/*');
    foreach($files as $file){
        if(is_file($file))
            unlink($file);
    }

    $output = shell_exec("sudo sshpass -p 'password' scp /home/ubuntu/git/IT490_PokePlace/directoryToSend/frontendBundle.tar.gz ubuntu@10.0.0.201:/home/ubuntu/");

    //var dumps for error checking
    $files = scandir('/home/ubuntu/git/IT490_PokePlace/directoryToSend');
    echo "Var dump of _directoryToSend_ contents: ";
    var_dump($files);
    echo "Var dump of _scp command_ output: ";
    var_dump($output);

    $request = array();
    $request['type'] = "deploy_frontend";

    $response = createClientRequest($request);
    echo "Response from deployment server: ";
    echo $response;


    //CODE FOR RMQ REQUEST
    function createClientRequest($request){
        $client = new rabbitMQClient("/home/ubuntu/git/IT490_PokePlace/rabbitmqphp_example/rabbitMQ_deployment.ini", "testServer");
        $response = $client->send_request($request);

        return $response;
    }
