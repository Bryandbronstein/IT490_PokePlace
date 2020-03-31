<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Leaderboards</title>
</head>
<body onload="leaderboard()">
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="search.php">Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="forum.php">Forums</a>
            </li>
            <li class="nav-item active">
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

    <div id="leaderboard_results">
<!--
        <table class="table table-hover table-dark">
            <thead>
            <tr>
                <th><span class="tableTitle">Username</span></th>
                <th><span class="tableTitle">Wins</span></th>
                <th><span class="tableTitle">Losses</span></th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-center">
                <td>' .$row['username']. '</td>
                <td>' .$row['wins']. '</td>
                <td>' .$row['losses']. '</td>
            </tr>
            </tbody>
        </table>
-->
    </div>

    <div class="battleDiv">
        <h2 style="font-weight: bolder; padding-bottom: 30px;">Time to Battle!</h2>
        <img alt="An angry Snorlax" id="battle_image" class="img-fluid"
             src="https://pngimage.net/wp-content/uploads/2018/06/pokemon-snorlax-png-7.png">
        <h4>Click the button below to battle another user on the site!</h4>
        <button type="button" id='battleButtonId' class="btn btn-dark btn-lg" data-toggle="modal" data-target="#battlemodal"><i class="fas fa-bolt"></i> Battle! <i class="fas fa-bolt"></i></button>
    </div>

</div>



<div class="modal fade" id="battlemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Battle!</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-padding username-group">
                        <label for="username_toBattle">Enter the username of the person you wish to battle:</label>
                        <input type="text" class="form-control" id="username_toBattle" aria-describedby="emailHelp">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="loginButtonId" class="btn btn-primary btn-lg" onclick="battle()">Start Battle!</button>
            </div>
        </div>
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