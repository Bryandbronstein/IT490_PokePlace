<?php
session_start();
//$_SESSION['username'] = "bob";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Welcome to Pokeplace!</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
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

<div class="container">
    <div class="jumbotron My_jumbotron text-center">
        <img alt="A group of pokemon" class="img-fluid" src="https://www.popmythology.com/wp-content/uploads/2014/11/13715545605551.png">
        <h1>Welcome to Pokeplace!</h1>
        <p class="lead">A place to search for, discuss, and simulate battles with Pokemon!<br>  This site includes:<br>
        <div id="homepage_list">
            <ul>
                <li>A robust search engine of all Pokemon up to Generation 1</li>
                <li>Forums for discussion</li>
                <li>Battle simulation system</li>
                <li>And leaderboards to rank the top competitors of those battles</li>
            </ul>
        </div>
        <p class="lead">Sign up for a free account below!</p>
    </div>
    <div style="margin-bottom: 20px;" class="text-center">
        <button type="button" id="registerButtonId" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#registermodal">Sign Up!</button>
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


    <div class="modal fade" id="registermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Register</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-padding name-group form-row">
                            <div class="col">
                                <label for="id_firstname">First Name:</label>
                                <input type="text" class="form-control" id="id_firstname" aria-describedby="emailHelp">
                            </div>
                            <div class="col">
                                <label for="id_lastname">Last Name:</label>
                                <input type="text" class="form-control" id="id_lastname" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="form-padding username-group">
                            <label for="id_username">Username:</label>
                            <input type="text" class="form-control" id="id_username" aria-describedby="emailHelp">
                        </div>
                        <div class="form-padding email-group">
                            <label for="id_email">Email:</label>
                            <input type="email" class="form-control" id="id_email" aria-describedby="emailHelp">
                        </div>
                        <div class="form-padding password-group form-row">
                            <div class="col">
                                <label for="id_password">Password:</label>
                                <input type="password" class="form-control" id="id_password" aria-describedby="emailHelp">
                            </div>
                            <div class="col">
                                <label for="id_confirm_password">Confirm Password:</label>
                                <input type="password" class="form-control" id="id_confirm_password" aria-describedby="emailHelp">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="registerButtonId" class="btn btn-danger btn-lg" onclick="checkRegisterCredentials()">Submit</button>
                </div>
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
