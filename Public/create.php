<?php 

// this code will only execute after the submit button is clicked
if (isset($_POST['submit'])) {

//include the config file 
require"../config.php";
try{

$connection = new PDO($dsn, $username, $password, $options);

$new_task = array (
    "taskname" => $_POST['taskname'],
    "duedate" => $_POST['duedate'],
    "taskdetail" => $_POST['taskdetail'],
    "occurance" => $_POST['occurance'],
);

$sql = "INSERT INTO works (
    taskname,
    duedate,
    taskdetail,
    occurance
    ) VALUES (
    :taskname,
    :duedate,
    :taskdetail,
    :occurance
    )";

$statement = $connection->prepare($sql);
$statement->execute($new_task);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
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
<label for="occurence">Occurence</label> 
<input type="enum" name="occurence" id="occurence"> 
<input type="submit" name="submit" value="Submit">
</form>

<?php include "templates/footer.php"; ?>
