<?php
session_start();
 
// Check if the user is already logged in, if yes then redirect to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
//include the config and common file 
require "../config.php";
require "common.php";
 
// Define variables and initialize
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if($stmt = $pdo_connection->prepare($sql)){
            
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct
                            session_start();                          
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        unset($stmt);
    }
    unset($pdo_connection);
}
?>

<!doctype html>
<html lang="en"> 
    <head>
        <title>My to-do List</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    </head>

<body>
    <div class="container is-mobile">
        <header>
            <div class="block">
                <navbar class="navbar">
                    <div class= "navbar-left">
                        <a href="index.php" class = "navbar-item">
                        <h1 class = "title is-4">My to-do list</h1>
                        </a>
                    </div>
                </navbar>
            </div>
        </header>

        <div class="container is-mobile">
            <div class="block">
                <section class="hero">
                    <div class= "hero-body">
                        <div class= "container">
                            <h2 class="title">Login</h2>
                            <p class= "subtitle">Enter your details</p>
                        </div>
                    </div>
                </section>
            </div>

            <div class="card">   
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="column">        
                        <div class="form <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label> Username </label>
                            <input type="text" class="input" name="username" placeholder="username" value="<?php echo $username; ?>">
                            <span><?php echo $username_err; ?></span>
                        </div>    
                    </div>

                    <div class="column">
                        <div class="form <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label> Password </label>
                            <input type="password" class="input" name="password" placeholder= "Password">
                            <span><?php echo $password_err; ?></span>
                        </div>
                    </div>

                    <div class="column">
                        <div class="form">
                            <input type="submit" class="button is-link is-small" value="Login">
                        </div>
                    </div>
                </form>
            </div>

            <footer class="card-footer">
                <p class="card-footer-item">
                Don't have an account? <a href="register.php"> Create your to-do list now</a>.</p>
            </footer>
        </div>
    </div>
</body>
</html>