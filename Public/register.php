<?php 

    //include the config and common file 
    require "../config.php";
    require "common.php";
    
    // Define variables and initialize 
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";
    
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
        } else{
        
            $sql = "SELECT id FROM users WHERE username = :username";
            
            if($stmt = $pdo_connection->prepare($sql)){
            
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                
            // Set parameters
            $param_username = trim($_POST["username"]);
                 
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $username_err = "This username is already taken.";
                    } else{
                        $username = trim($_POST["username"]);
                    }
                    } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            unset($stmt);
        }
        
    // Validate password
    if(empty(trim($_POST["password"]))){

        $password_err = "Please enter a password.";    

        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Password must have atleast 6 characters.";

        } else{
            $password = trim($_POST["password"]);
        }
        
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";    

        } else{
            $confirm_password = trim($_POST["confirm_password"]);

            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }
        
    // Check input errors 
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            
            if($stmt = $pdo_connection->prepare($sql)){
        
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
    
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
                
                if($stmt->execute()){

                    header("location: login.php");
                } else{
                    echo "Something went wrong. Please try again later.";
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

    <div class="container">
        <div class="block">
            <section class="hero">
                <div class= "hero-body">
                    <div class= "container">
                        <h2 class="title">Sign Up</h2>
                        <p class="subtitle">Please fill this form to create an account.</p>
                    </div>
                </div>
            </section>
        </div>
        <div class="container">
            <div class ="card">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="column">   
                        <div class="form <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" class="input" name="username" value="<?php echo $username; ?>">
                            <span class="block"><?php echo $username_err; ?></span>
                        </div>   
                    </div> 

                    <div class="column">            
                        <div class="form <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" class="input" name="password" value="<?php echo $password; ?>">
                            <span class="block"><?php echo $password_err; ?></span>
                        </div>
                    </div>

                    <div class="column">
                        <div class="form <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label>Confirm Password</label>
                            <input type="password" class="input" name="confirm_password" value="<?php echo $confirm_password; ?>">
                            <span class="block"><?php echo $confirm_password_err; ?></span>
                        </div>
                    </div>
                
                    <div class="column">
                        <div class="form">
                            <input type="submit" class="button is-link is-small" value="Submit">
                        </div>
                    </div>
                </form>  
            </div> 
        </div>
    </div>
</div>
<footer class="card-footer">
    <p class="card-footer-item">
    Already have an account? <a href="login.php"> Login here</a>.</p>
</footer>
</body>
</html>