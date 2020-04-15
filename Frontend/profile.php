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
    <link rel="icon" href="pokeball.png"/>
    <title><?php echo $_SESSION['username']?>'s Profile</title>
</head>
<body onload="loadPokemon()">
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
 <h1 >Hello, <?php echo $_SESSION['username']?>!</h1>
    <h2 >Here is your current Pokemon team:</h2>
    <div id="users_pokemon">
    <!--
         <table class="table table-hover table-dark">
             <thead>
             <tr>
                 <th><span class="tableTitle">Pokemon #1</span></th>
                 <th><span class="tableTitle">Pokemon #2</span></th>
                 <th><span class="tableTitle">Pokemon #3</span></th>
                 <th><span class="tableTitle">Pokemon #4</span></th>
                 <th><span class="tableTitle">Pokemon #5</span></th>
                 <th><span class="tableTitle">Pokemon #6</span></th>
                 </tr>
             </thead>
             <tbody>
             <tr>
                 <td>' .$row['pokemon_1']. '</td>
                 <td>' .$row['pokemon_2']. '</td>
                 <td>' .$row['pokemon_3']. '</td>
                 <td>' .$row['pokemon_4']. '</td>
                 <td>' .$row['pokemon_5']. '</td>
                 <td>' .$row['pokemon_6']. '</td>
             </tr>
             </tbody>
         </table>
         -->
    </div>



    <div id="friends_list">

        <table id="friendslist_table" class="table table-hover table-dark">
            <thead>
            <tr>
                <th colspan="6" id="friendslist_header"><span class="tableTitle">Friends List</span></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Bob</td>
            </tr>
            <tr>
                <td>Bob</td>
            </tr>
            <tr>
                <td>Bob</td>
            </tr>
            <tr>
                <td>Bob</td>
            </tr>
            </tbody>
        </table>
        <button type="button" id="addFriendButtonId" class="btn btn-outline-primary btn-lg" data-toggle="modal" data-target="#friendmodal"><i class="fas fa-user-plus"></i> Add Friend</button>

    </div>

    <button type="button" id="addFriendButtonId" class="btn btn-outline-danger btn-lg" onclick="loadFriends()"><i class="fas fa-user-plus"></i> TEST load friends</button>
    <div id="user_list"></div>

    <div class="battleDiv">
        <h2 style="font-weight: bolder; padding-bottom: 30px;">Time to Battle!</h2>
        <img alt="An angry Snorlax" id="battle_image" class="img-fluid"
             src="https://pngimage.net/wp-content/uploads/2018/06/pokemon-snorlax-png-7.png">
        <h4>Click the button below to battle another user on the site!</h4>
        <button type="button" id='battleButtonId' class="btn btn-dark btn-lg" data-toggle="modal" data-target="#battlemodal" onclick="loadFriends()"><i class="fas fa-bolt"></i> Battle! <i class="fas fa-bolt"></i></button>
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
                <div class="form-padding username-list-group">
                    <h3 style="font-weight: bold; text-align: center; margin-bottom: 20px;">Battle one of your friends</h3>
                    <input type="checkbox" id="testa" class="css-checkbox" name="users[]" value="bb389" /><label for="testa" class="css-label">bb389</label>
                    <input type="checkbox" id="testb" class="css-checkbox" name="users[]" value="bob" /><label for="testb" class="css-label">bob</label>
                    <input type="checkbox" id="testc" class="css-checkbox" name="users[]" value="hq33" /><label for="testc" class="css-label">hq33</label>
                    <input type="checkbox" id="testd" class="css-checkbox" name="users[]" value="testusername" /><label for="testd" class="css-label">testusername</label>
                </div>
                <div class="bordered-text-div">
                    <div class="border-line"></div>
                    <h2 class="bordered-text">Or</h2>
                    <div class="border-line"></div>
                </div>
                <h3 style="font-weight: bold; text-align: center; margin-bottom: 20px;">Battle a random user</h3>
                <div class="form-padding" style="text-align: center">
                    <input type="checkbox" id="random" class="css-checkbox" name="random" value="random" /><label for="random" class="css-label">Random User</label>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id='battleButtonId' class="btn btn-warning btn-lg" data-toggle="modal" data-target="#battlemodal"'><i class="fas fa-bolt"></i> Start Battle! <i class="fas fa-bolt"></i></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="friendmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">Select a User to Add as Friend</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-padding username-list-group">
                        <!--<label><input type="checkbox" name="users[]" value=' .$row['username']. '>$row['username']</label>-->
                        <input type="checkbox" id="test1" class="css-checkbox" name="users[]" value="bb389" /><label for="test1" class="css-label">bb389</label>
                        <input type="checkbox" id="test2" class="css-checkbox" name="users[]" value="bob" /><label for="test2" class="css-label">bob</label>
                        <input type="checkbox" id="test3" class="css-checkbox" name="users[]" value="hq33" /><label for="test3" class="css-label">hq33</label>
                        <input type="checkbox" id="test4" class="css-checkbox" name="users[]" value="testusername" /><label for="test4" class="css-label">testusername</label>
                    </div>
                </form>
            </div>
                    <div class="modal-footer">
                        <button type="button" id="loginButtonId" class="btn btn-primary btn-lg" onclick="displayFriendsTEST()">Add</button>
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
            <iframe name="hiddenFrame" width="0" height="0" style="display: none;"></iframe>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/761d96f64b.js" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
</body>
</html>
