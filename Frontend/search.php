<?php
session_start();
//$_SESSION['username'] = "bob";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Search Our Database</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="search.php">Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="forum.php">Forums</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="leaderboard.php">Leaderboards</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto mr-1">
            <?php
            if (isset($_SESSION['username'])){
                $username = $_SESSION['username'];
                echo "<li class=\"nav-item dropdown\">
                <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                  Hello, $username
                </a>
                <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                  <a class=\"dropdown-item\" href=\"profile.php\">Profile</a>
                  <div class=\"dropdown-divider\"></div>
                  <button type=\"button\" style='margin-left:20px;' id='logoutButtonId' class=\"btn btn-danger btn-sm\" onclick='logout()'>Logout</button>
                </div>
              </li>";
            }else {
                echo "<button type=\"button\" class=\"btn btn-primary btn-lg\" data-toggle=\"modal\" data-target=\"#loginmodal\"><i class=\"fas fa-user-alt\"></i> Login In</button>";
            }
            ?>
        </ul>
    </div>
</nav>

<div style="margin-top: 30px;" class="container">
    <form class="form-padding search-group text-center">
        <h3>First, select the parameter you would like to search by:</h3>
        <select id="search_type" class="form-margin-bottom mr-sm-2 form-control form-control-lg" onchange="showDiv('hidden_div', this)">
            <option value="" selected>Search by...</option>
            <option value="name">Name (Squirtle, Bulbasaur, etc.)</option>
            <option value="pokemonNum">Pokedex Number (1, 13, 25, etc.)</option>
            <option value="pokeType">Type (Fire, Water, Fairy, etc.)</option>
            <option value="ability">Ability (Flame Body, Magic Guard, etc.)</option>
        </select>
        <div id="hidden_div" class="form-margin-bottom">
            <label class="lead" for="pokemon_search"><h2>Now, search using your selected parameter below:</h2></label>
            <input type="text" class="form-control form-control-lg" id="pokemon_search" placeholder="Input your search criteria here">
            <button style="margin-top: 10px;" class="btn btn-lg btn-outline-warning" type="button" onclick="checkSearchFields()"><i class="fas fa-search"></i> Search</button>
        </div>
    </form>

    <div id="search_results">


    </div>

</div>






<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Login</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-padding username-group">
                        <label for="username_login">Username:</label>
                        <input type="text" class="form-control" id="username_login" aria-describedby="emailHelp">
                    </div>
                    <div class="form-padding password-group">
                        <label for="password_login">Password:</label>
                        <input type="password" class="form-control" id="password_login">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="loginButtonId" class="btn btn-primary btn-lg" onclick="checkLoginCredentials()">Submit</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/761d96f64b.js" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
</body>
</html>
