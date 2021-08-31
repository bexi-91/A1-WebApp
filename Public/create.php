<?php 
session_start(); 

// after the submit button is clicked
if (isset($_POST['submit'])) {

//include the config and common file 
require "../config.php";
require "common.php";

try{
$connection = new PDO($dsn, $username, $password, $options);

$new_task = array (
    "userid" => $_SESSION['id'],
    "taskname" => $_POST['taskname'],
    "duedate" => $_POST['duedate'],
    "taskdetails" => $_POST['taskdetails'],
);

$sql= "INSERT INTO works (
    userid,
    taskname,
    duedate,
    taskdetails    
    ) 
    VALUES (
        :userid,
    :taskname,
    :duedate,
    :taskdetails   
    )";

$statement = $connection->prepare($sql);
$statement->execute($new_task);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();}
    }
?>

<?php include "templates/header.php"; ?>
    <div class="block">
        <section class="hero">
            <div class= "hero-body">
                <div class= "container">
                    <h2 class="title"> Create a new task </h2>
                </div>
            </div>
        </section>
    </div>

    <?php if (isset($_POST['submit']) && $statement) { ?>
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    Task successfully added!
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    <p> Add another task or <a href="update.php"> View task list </a> </p> 
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- collect task information -->
    <div class="container">
        <div class="block">
            <form method="post">
                <div class="field">
                    <div class="column">
                        <label for="taskname">Task</label> 
                        <input type="text" class="input" name="taskname" id="taskname"> 
                    </div>

                    <div class="column">
                        <label for="duedate">Due Date</label> 
                        <input type="date" class="input" required name="duedate" id="duedate"> 
                    </div>

                    <div class="column">
                        <label for="taskdetails">Task Details</label> 
                        <input type="text" class="input" name="taskdetails"  id="taskdetails"> 
                    </div>

                    <div class="column">
                        <input class= "button is-link" type="submit" name="submit" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php include "templates/footer.php"; ?>
