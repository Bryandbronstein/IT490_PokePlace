<?php
require_once('../rabbitmqphp_example/path.inc');
require_once('../rabbitmqphp_example/get_host_info.inc');
require_once('../rabbitmqphp_example/rabbitMQLib.inc');

session_start();
$searchType = $_GET['searchType'];
$pokeName = $_SESSION['pokeName'];
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
        $request['cat_id'] = $_SESSION['cat_id'];
        $response = createClientRequest($request);
        echo $response;
        break;

    case "CreateTopic":
        $request = array();

        $request['type'] = "CreateTopics";
        $request['topic_subject'] = $_GET['topicName'];
        $request['cat_id'] = $_SESSION['cat_id'];

        $response = createClientRequest($request);
        echo $response;
        break;

    case "LoadPosts":
        $request = array();

        $request['type'] = "LoadPosts";
        $request['topic_id'] = $_SESSION['topic_id'];
        $response = createClientRequest($request);
        echo $response;
        break;

    case "CreatePost":
        $request = array();

        $request['type'] = "CreatePosts";
        $request['post_content'] = $_GET['postText'];
        $request['topic_id'] = $_SESSION['topic_id'];
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

        $response_json = createClientRequest($request);

        $response = json_decode($response_json);
        $tempString = "";

        if ($response -> speed){

            $_SESSION['pokeName'] = $response -> pokemonName;

            $tempString .= '<h1 class="text-center">' .$response -> pokemonName . '</h1>';
            $tempString .= '<table class="table table-hover table-dark">';
            $tempString .= '<thead>';
            $tempString .= '<tr>';
                $tempString .= '<th><span class="tableTitle">HP</span></th>';
                $tempString .= '<th><span class="tableTitle">Attack</span></th>';
                $tempString .= '<th><span class="tableTitle">Defense</span></th>';
                $tempString .= '<th><span class="tableTitle">Special Attack</span></th>';
                $tempString .= '<th><span class="tableTitle">Special Defense</span></th>';
                $tempString .= '<th><span class="tableTitle">Speed</span></th>';
            $tempString .= '</tr>';
            $tempString .= '</thead>';
            $tempString .= '<tbody>';
            $tempString .= '<tr>';
                $tempString .= '<td>' .$response -> hp . '</td>';
                $tempString .= '<td>' .$response -> atk. '</td>';
                $tempString .= '<td>' .$response -> def. '</td>';
                $tempString .= '<td>' .$response -> spAtk. '</td>';
                $tempString .= '<td>' .$response -> spDef. '</td>';
                $tempString .= '<td>' .$response -> speed. '</td>';
            $tempString .= '</tr>';
            $tempString .= '</tbody>';
        $tempString .= '</table>';
            $tempString .= '<button type="button" id="addPokemon" class="btn btn-outline-warning btn-lg" onclick="addPokemon()" ><i class="fas fa-edit"></i> Add Pokemon to Team</button>';

        }else {

            $pokemonList = $response -> pokemonNames;

            $tempString .= '<table class="table table-hover table-dark">';
            $tempString .= "<thead>";
            $tempString .= " <tr>";
            $tempString .= '<th colspan="6"><span class="tableTitle">Search Results</span></th>';
            $tempString .= "</tr>";
            $tempString .= "</thead>";
            $tempString .= "<tbody>";
            $tempString .= "<tr>";
            foreach ($pokemonList as $name) {
                $tempString .= '<td><a href="pokemon.php?name=' . $name . '"><span class="categoryTitle">' . $name . '</span></a></td>';
                $tempString .= "  </tr>";
                $tempString .= " <tr>";
            }
            $tempString .= " </tbody>";
            $tempString .= " </table>";
        }
        echo $tempString;

        break;

    case "SinglePokeSearch":
        $request = array();

        $request['type'] = "Search";
        $request['name'] = $pokeName;
        $request['pokemonNum'] = "na";
        $request['pokeType'] = "na";
        $request['ability'] = "na";

        $response_json = createClientRequest($request);
        $response = json_decode($response_json);

        $tempString .= '<h1 class="text-center">' .$response -> pokemonName . '</h1>';
        $tempString .= '<table class="table table-hover table-dark">';
        $tempString .= '<thead>';
        $tempString .= '<tr>';
        $tempString .= '<th><span class="tableTitle">HP</span></th>';
        $tempString .= '<th><span class="tableTitle">Attack</span></th>';
        $tempString .= '<th><span class="tableTitle">Defense</span></th>';
        $tempString .= '<th><span class="tableTitle">Special Attack</span></th>';
        $tempString .= '<th><span class="tableTitle">Special Defense</span></th>';
        $tempString .= '<th><span class="tableTitle">Speed</span></th>';
        $tempString .= '</tr>';
        $tempString .= '</thead>';
        $tempString .= '<tbody>';
        $tempString .= '<tr>';
        $tempString .= '<td>' .$response -> hp . '</td>';
        $tempString .= '<td>' .$response -> atk. '</td>';
        $tempString .= '<td>' .$response -> def. '</td>';
        $tempString .= '<td>' .$response -> spAtk. '</td>';
        $tempString .= '<td>' .$response -> spDef. '</td>';
        $tempString .= '<td>' .$response -> speed. '</td>';
        $tempString .= '</tr>';
        $tempString .= '</tbody>';
        $tempString .= '</table>';
        $tempString .= '<button type="button" id="addPokemon" class="btn btn-outline-warning btn-lg" onclick="addPokemon()" ><i class="fas fa-edit"></i> Add Pokemon to Team</button>';


        echo $tempString;
        break;

    case "LoadPokemon":
        $request = array();

        $request['type'] = "LoadPokemon";
        $request['username'] = $_SESSION['username'];

        $response = createClientRequest($request);
        echo $response;
        break;

    case "AddPokemon":
        $request = array();

        $request['type'] = "AddPokemon";
        $request['username'] = $_SESSION['username'];
        $request['pokemonName'] = $_SESSION{'pokeName'};

        $response = createClientRequest($request);
        echo $response;
        break;

    case "LoadLeaderboard":
        $request = array();

        $request['type'] = "LoadLeaderboard";

        $response = createClientRequest($request);
        echo $response;
        break;

    case "Battle":

        $request = array();

        $request['type'] = "Battle";
        $request['username_1'] = $_SESSION['username'];
        $request['username_2'] = $_GET['useranme_toBattle'];

        $response_json = createClientRequest($request);
        $response = json_decode($response_json);

        echo $response -> user1;
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
    $client = new rabbitMQClient("/home/bryan/git/IT490-Spring2020/rabbitmqphp_example/rabbitMQ_db.ini", "testServer");
    $response = $client->send_request($request);

    return $response;
}

?>


