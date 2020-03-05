function checkLoginCredentials(){
    //  Taking Form input
    let username = document.getElementById("username_login").value;
    let password = document.getElementById("password_login").value;

    if (username !== "" && password !== ""){
        sendLoginCredentials(username, password);
    }else{
        alert("Please fill out all required information");
    }
}
function sendLoginCredentials(username, password){
    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            document.getElementById("loginButtonId").innerHTML = "Login";

            console.log(this.responseText);
            alert(this.responseText);

            if(this.responseText == true){
                alert("Logged in successfully");
                window.location = "profile.php";
            }else{
                alert("Problem logging in.  Please try again");
            }

        }else{
            document.getElementById("loginButtonId").innerHTML = "Loading...";
        }
    };
    httpReq.open("GET", "functions.php?type=Login&username=" + username + "&password=" + password);
    httpReq.send(null);
}

function logout() {
    if (confirm('Are you sure you want log out?')) {
        let httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("logoutButtonId").innerHTML = "Logout";

                if (this.responseText == true) {
                    alert("Logged out successfully");
                    window.location = "index.php";
                } else {
                    alert("Problem logging out user.  Please try again");
                }
            } else {
                document.getElementById("logoutButtonId").innerHTML = "Loading...";
            }
        };
        httpReq.open("GET", "functions.php?type=Logout");
        httpReq.send(null);
    } else {
        //cancels login request
    }
}
//  Form validation for Register
function checkRegisterCredentials(){
    //  Taking Form input
    let firstname = document.getElementById("id_firstname").value;
    let lastname = document.getElementById("id_lastname").value;
    let username = document.getElementById("id_username").value;
    let email = document.getElementById("id_email").value;
    let password = document.getElementById("id_password").value;
    let confirmPassword = document.getElementById("id_confirm_password").value;

    if (firstname !== "" && lastname !== "" && username !== "" && email !== "" && password !== "" && confirmPassword !== ""){
       if (password == confirmPassword) {
           sendRegisterCredentials(firstname, lastname, username, email, password);
       }else{
           alert("Password and Confirm Password must match");
       }
    }else{
        alert("Please fill out all required information");
    }
}

//  This function sends a AJAX request for Register new user
function sendRegisterCredentials(firstname, lastname, username, email, password){
    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            document.getElementById("registerButtonId").innerHTML = "Register";

            if(this.responseText === "True"){
                alert("Registered successfully!  You may now login with your new credentials");
                window.location = "index.php";
            }else{
                alert("Problems registering you as a new user.  Please try again");
            }
        }else{
            document.getElementById("registerButtonId").innerHTML = "Loading...";
        }
    };
    httpReq.open("GET", "functions.php?type=Register&username=" + username +
        "&password=" + password + "&firstname=" + firstname + "&lastname=" + lastname + "&email=" + email);
    httpReq.send(null);
}

function loadCategories() {
    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("categoriesTable").innerHTML = this.responseText;

        }
    };
    httpReq.open("GET", "functions.php?type=LoadCategories");
    httpReq.send(null);
}
function loadTopics() {
    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("topicssTable").innerHTML = this.responseText;
        }

    };
    httpReq.open("GET", "functions.php?type=LoadTopics&cat_id=" + cat_id);
    httpReq.send(null);
}
function loadPosts() {
    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("postsTable").innerHTML = this.responseText;
        }

    };
    httpReq.open("GET", "functions.php?type=LoadPosts&topic_id=" + topic_id);
    httpReq.send(null);
}
function checkCategoryFields(){

    let catName = document.getElementById('category_name').value;
    let catDesc = document.getElementById('category_desc').value;

    if (catName !== "" && catDesc !== ""){
        console.log(catName + catDesc);
        createCategory(catName, catDesc);
    }else{
        alert("Please fill in all required fields");
    }
}
function createCategory(catName, catDesc) {
    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            if(this.responseText == true){
                alert("New category created successfully!");
                window.location = "forum.php";
            }else{
                alert("Problems creating new category.  Please try again");
            }
        }
    };
    httpReq.open("GET", "functions.php?type=CreateCategory&catName=" + catName + "&catDesc=" + catDesc);
    httpReq.send(null);
}
function checkTopicFields(){

    let topicName = document.getElementById('topic_name').value;
    let topicDesc = document.getElementById('topic_desc').value;

    if (topicName !== "" && topicDesc !== ""){
        createTopic(topicName, topicDesc);
    }else{
        alert("Please fill in all required fields");
    }
}
function createTopic(topicName, topicDesc) {
    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            if(this.responseText == true){
                alert("New topic created successfully!");
                window.location = "category.php?id=" + cat_id;
            }else{
                alert("Problems creating new topic.  Please try again");
            }
        }
    };
    httpReq.open("GET", "functions.php?type=CreateTopic&cat_id=" + cat_id + "&topicName=" + topicName + "&topicDesc=" + topicDesc);
    httpReq.send(null);
}

function checkPostFields(){
    let postText = document.getElementById('post_desc').value;

    if (postText !== ""){
        createPost(postText);
    }else{
        alert("Please fill in all required fields");
    }
}
function createPost(postText) {
    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            if(this.responseText == true){
                alert("New post created successfully!");
                window.location = "forum.php";
            }else{
                alert("Problems creating new category.  Please try again");
            }

        }
    };
    httpReq.open("GET", "functions.php?type=CreatePost&postText=" + postText + "&topic_id=" + topic_id);
    httpReq.send(null);
}
function showDiv(divId, element) {
    document.getElementById(divId).style.display = element.value !== "" ? 'block' : 'none';
}

function checkSearchFields(){
    let searchText_upper = document.getElementById('pokemon_search').value;
    let dropdown = document.getElementById("search_type");
    let searchType = dropdown.options[dropdown.selectedIndex].value;

    let searchText = searchText_upper.toLowerCase();

    if (searchText !== ""){
        createSearch(searchText, searchType);

    }else{
        alert("Please fill in all required fields");
    }
}

function createSearch(searchText, searchType) {

    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("search_results").innerHTML = this.responseText;

        }
    };
    httpReq.open("GET", "functions.php?type=Search&searchType=" + searchType + "&searchText=" + searchText);
    httpReq.send(null);
}

function singlePokeSearch() {

    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("pokemon_results").innerHTML = this.responseText;

        }
    };
    httpReq.open("GET", "functions.php?type=SinglePokeSearch");
    httpReq.send(null);
}

function addPokemon() {

    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            if(this.responseText == true){
                alert("Pokemon successfully added to your team!");
                window.location = "profile.php";
            }else{
                alert("Problem adding pokemon to your team.  Please try again.  Note: you may only have 6 pokeomon on your team ata time");
            }
        }
    };
    httpReq.open("GET", "functions.php?type=AddPokemon");
    httpReq.send(null);
}

function loadPokemon() {

    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            console.log(this.responseText);
            alert(this.responseText);
            document.getElementById("users_pokemon").innerHTML = this.responseText;

        }
    };
    httpReq.open("GET", "functions.php?type=LoadPokemon");
    httpReq.send(null);
}

function loadPokemon() {

    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            console.log(this.responseText);
            alert(this.responseText);
            document.getElementById("leaderboard_results").innerHTML = this.responseText;

        }
    };
    httpReq.open("GET", "functions.php?type=LoadLeaderboard");
    httpReq.send(null);
}

function battle() {

    let httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("pokemon_results").innerHTML = this.responseText;

        }
    };
    httpReq.open("GET", "functions.php?type=SinglePokeSearch");
    httpReq.send(null);
}





