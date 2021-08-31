<?php
session_start();
 
// Check if the user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
//include the config and common file 
require "../config.php";
require "common.php";
 
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        
        if($stmt = $pdo_connection->prepare($sql)){
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }      
        unset($stmt);
    }
    unset($pdo_connection);
}
?>
 
<?php include "templates/header.php"; ?>
<body>
    <div class="container">
        <div class="block">
            <section class="hero">
                <div class= "hero-body">
                    <div class= "container">
                        <h2 class="title">Reset Password</h2>
                        <p class="subtitle">Please fill out this form to reset your password.</p>
                    </div>
                </div>
            </section>
        </div>

        <div class="block">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                <div class="column">
                    <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                        <label>New Password</label>
                        <input type="password" class="input" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                        <span class="help-block"><?php echo $new_password_err; ?></span>
                    </div>
                </div>

                <div class="column">
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label>Confirm Password</label>
                        <input type="password" class="input" name="confirm_password" class="form-control">
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                </div>

                <div class="column">
                    <div class="form-group">
                        <input type="submit" class="button is-link" value="Submit">
                        <a class="button is-danger" href="index.php">Cancel</a>
                    </div>
                </div>
            </form>
        </div>  
    </div>  
<?php include "templates/footer.php"; ?>