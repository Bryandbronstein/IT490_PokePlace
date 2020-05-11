<?php
    
require_once('/home/ubuntu/git/it490-dmz/rabbitmqphp_example/path.inc');
    require_once('/home/ubuntu/git/it490-dmz/rabbitmqphp_example/get_host_info.inc');
    require_once('/home/ubuntu/git/it490-dmz/rabbitmqphp_example/rabbitMQLib.inc');    
//STEPS TO MAKE THIS SCRIPT WORK
//1. Create empty directories "directoryToBuild" and "directoryToSend"
//2. Set permissions for these directories: "sudo chmod 777 PATH_TO_DIRECTORIES"
//3. Edit paths within this script to match the paths to the directories you just created
//4. Any time you see frontend, replace it with the name of your machine (backend, dmz, etc.)

$a = new PharData('/home/ubuntu/directoryToBuild/dmzBundle.tar');
$a->buildFromDirectory('/home/ubuntu/directoryToBuild');
$a->compress(Phar::GZ);
rename('/home/ubuntu/directoryToBuild/dmzBundle.tar.gz', '/home/ubuntu/directoryToSend/dmzBundle.tar.gz');

$files = glob('/home/ubuntu/directoryToBuild/*');
foreach($files as $file){
    if(is_file($file))
        unlink($file);
}


$output = shell_exec("sudo sshpass -p 'password' scp /home/ubuntu/directoryToSend/dmzBundle.tar.gz ubuntu@10.0.0.201:/home/ubuntu/versions/dmz");

//var dumps for error checking
$files = scandir('/home/ubuntu/directoryToSend');
echo "Var dump of _directoryToSend_ contents: ";
var_dump($files);
echo "Var dump of _scp command_ output: ";
var_dump($output);

$files2 = glob('/home/ubuntu/directoryToSend/*');
foreach($files2 as $file){
    if(is_file($file))
        unlink($file);
}


$request = array();
$request['type'] = "deploy_dmz";

$response = createClientRequest($request);
echo "Response from deployment server: ";
echo $response;


//CODE FOR RMQ REQUEST
function createClientRequest($request){
    $client = new rabbitMQClient("/home/ubuntu/git/it490-dmz/rabbitmqphp_example/rabbitMQ_deployment.ini", "testServer");
    $response = $client->send_request($request);

    return $response;
}


?>



