<?php
require_once('../rabbitmqphp_example/path.inc');
require_once('../rabbitmqphp_example/get_host_info.inc');
require_once('../rabbitmqphp_example/rabbitMQLib.inc');

session_start();
$searchType = $_GET['searchType'];
$type = $_GET["type"];
//  determines what kind of data was sent via javascript.js
switch ($type) {
    case "Login":
        $username = $_GET["username"];
        $password = $_GET["password"];
        $response = login($username, $password);
        echo $response;
        break;

    case "Logout":
        session_destroy();
        $response = true;
        echo $response;
        break;

    case "Register":
        $firstname = $_GET["firstname"];
        $lastname = $_GET["lastname"];
        $username = $_GET["username"];
        $email = $_GET["email"];
        $password = $_GET["password"];
        $response = register($firstname, $lastname, $username, $email, $password);
        echo $response;
        break;

    case "LoadCategories":
        $request = array();

        $request['type'] = "LoadCategories";
        $response = createClientRequest($request);
        echo $response;
        break;

    case "CreateCategory":
        $request = array();

        $request['type'] = "CreateCategories";
        $request['cat_name'] = $_GET['catName'];
        $request['cat_description'] = $_GET['catDesc'];

        $response = createClientRequest($request);
        echo $response;
        break;

    case "LoadTopics":
        $request = array();

        $request['type'] = "LoadTopics";
        $request['cat_id'] = $_GET['cat_id'];
        $response = createClientRequest($request);
        echo $response;
        break;

    case "CreateTopic":
        $request = array();

        $request['type'] = "CreateTopics";
        $request['topic_subject'] = $_GET['topicName'];
        $request['cat_id'] = $_GET['cat_id'];

        $response = createClientRequest($request);
        echo $response;
        break;

    case "LoadPosts":
        $request = array();

        $request['type'] = "LoadPosts";
        $request['topic_id'] = $_GET['topic_id'];
        $response = createClientRequest($request);
        echo $response;
        break;

    case "CreatePost":
        $request = array();

        $request['type'] = "CreatePosts";
        $request['post_content'] = $_GET['postText'];
        $request['topic_id'] = $_GET['topic_id'];
        $request['username'] = $_SESSION['username'];

        $response = createClientRequest($request);
        echo $response;
        break;

    case "Search":
        $request = array();
        $request['type'] = "Search";

        switch ($searchType){
            case "name":
                $request['name'] = $_GET['searchText'];
                $request['pokemonNum'] = "na";
                $request['pokeType'] = "na";
                $request['ability'] = "na";
                break;

            case "pokemonNum":
                $request['name'] = "na";
                $request['pokemonNum'] = $_GET['searchText'];
                $request['pokeType'] = "na";
                $request['ability'] = "na";
                break;

            case "pokeType":
                $request['name'] = "na";
                $request['pokemonNum'] = "na";
                $request['pokeType'] = $_GET['searchText'];
                $request['ability'] = "na";
                break;

            case "ability":
                $request['name'] = "na";
                $request['pokemonNum'] = "na";
                $request['pokeType'] = "na";
                $request['ability'] = $_GET['searchText'];
                break;
            }
        $response = createClientRequest($request);
        echo $response;
        break;
}
//  This function will send a login request message to Db through RabbitMQ
function login($username, $password)
{
    $request = array();
    $request['type'] = "Login";
    $request['username'] = $username;
    $request['password'] = $password;

    $returnedValue = createClientRequest($request);

    if ($returnedValue == true) {
        $_SESSION["username"] = $username;
        $_SESSION["loggedIn"] = true;
    } else {
        session_destroy();
    }

    return $returnedValue;
}
//  This function will send register request to RabbitMQ
function register($firstname, $lastname, $username, $email, $password)
{
    $request = array();

    $request['type'] = "Register";
    $request['firstname'] = $firstname;
    $request['lastname'] = $lastname;
    $request['username'] = $username;
    $request['password'] = $password;
    $request['email'] = $email;

    $returnedValue = createClientRequest($request);

    return $returnedValue;
}
//  creates rabbitMq client request
function createClientRequest($request){
    $client = new rabbitMQClient("../rabbitmqphp_example/rabbitMQ_db.ini", "testServer");
    $response = $client->send_request($request);

    return $response;
}

?>


