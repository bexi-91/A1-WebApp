<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php include "templates/header.php"; ?>
<body>
    <div class="container is-mobile">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <h2 class= "title">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h2> 
                    <h3 class= "subtitle"> Welcome to your to-do list.</h3>
                    <p>It is time to be productive! Click on <a href="create.php"> 'Add a task' </a>to get started.</p>
                </div>
            </div>
        </div>
    </div>
<?php include "templates/footer.php"; ?>
