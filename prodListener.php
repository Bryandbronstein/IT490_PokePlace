require_once('/home/ubuntu/git/IT490_PokePlace/rabbitmqphp_example/path.inc');
require_once('/home/ubuntu/git/IT490_PokePlace/rabbitmqphp_example/get_host_info.inc');
require_once('/home/ubuntu/git/IT490_PokePlace/rabbitmqphp_example/rabbitMQLib.inc');

error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('log_errors', 'on');

function requestProcessor($request)
{
    echo "received request" . PHP_EOL;
    echo $request['type'];
    var_dump($request);

    if (!isset($request['type'])) {
        return array('message' => "ERROR: Message not found");
    }
    switch ($request['type']) {

        case "install_frontend":
            $file = scandir("/home/ubuntu/filesToInstall", 1);
            $response_msg = exec('sudo tar -xvf ' .$file[0]. ' --directory /home/ubuntu/git/IT490_PokePlace/Frontend');

            echo "Result: " . $response_msg;
            break;
    }


    echo $response_msg;
    return $response_msg;
}

$server = new rabbitMQServer('/home/ubuntu/git/IT490_PokePlace/rabbitmqphp_example/rabbitMQ_deployment.ini', 'testServer');

$server->process_requests('requestProcessor');

