
<?php
session_start();
 
// Check if the user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<?php include "templates/header.php"; ?>
<body>
    <div class="block">
        <section class="hero">
            <div class= "hero-body">
                <div class= "container">
                    <h1 class="title">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1> 
                    <p class="subtitle"> Manage your account here!</p>
                </div>
            </div>
        </section>
    </div>

    <div class="container">
        <div class="card">
            <div class="column">
                <a href="password_reset.php" class="button is-link is-small">Reset Your Password</a>
            </div>

            <div class="column">
                <a href="logout.php" class="button is-link is-small">Sign Out of Your Account</a>
            </div>
        </div>
    </div>
</body>
</html>