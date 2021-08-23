<?php 

// this code will only execute after the submit button is clicked
if (isset($_POST['submit'])) {

//include the config file 
require"../config.php";
require "common.php";
try{

$connection = new PDO($dsn, $username, $password, $options);

$new_task = array (
    "taskname" => $_POST['taskname'],
    "duedate" => $_POST['duedate'],
    "taskdetails" => $_POST['taskdetails'],
);

$sql= "INSERT INTO works (
    taskname,
    duedate,
    taskdetails    
    ) 
    VALUES (
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

<h2> Create a new task </h2>

<?php if (isset($_POST['submit']) && $statement) { ?>
<p>Task successfully added.</p>
<?php } ?>

<!-- for to collect task information -->
<form method="post">
<label for="taskname">Task</label> 
<input type="text" name="taskname" id="taskname"> 
<label for="duedate">Due Date</label> 
<input type="date" name="duedate" id="duedate"> 
<label for="taskdetails">Task Details</label> 
<input type="text" name="taskdetails" id="taskdetails"> 
<input type="submit" name="submit" value="Submit">
</form>

<?php include "templates/footer.php"; ?>
