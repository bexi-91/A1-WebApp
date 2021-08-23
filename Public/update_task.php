<?php 

// include the config file that we created last week
require "../config.php";
require "common.php";

// run when submit button is clicked
if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);  
        
        //grab elements from form and set as varaible
        $work =[
          "id"         => $_POST['id'],
          "taskname" => $_POST['taskname'],
          "duedate"  => $_POST['duedate'],
          "taskdetails"   => $_POST['taskdetails']
        ];
        
        // create SQL statement
        $sql = "UPDATE `works` 
                SET id = :id, 
                    taskname = :taskname, 
                    duedate = :duedate, 
                    taskdetails = :taskdetails, 
                WHERE id = :id";

        //prepare sql statement
        $statement = $connection->prepare($sql);
        
        //execute sql statement
        $statement->execute($work);

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

// GET data from DB
//simple if/else statement to check if the id is available
if (isset($_GET['id'])) {
    //yes the id exists 
    
    try {
        // standard db connection
        $connection = new PDO($dsn, $username, $password, $options);
        
        // set if as variable
        $id = $_GET['id'];
        
        //select statement to get the right data
        $sql = "SELECT * FROM works WHERE id = :id";
        
        // prepare the connection
        $statement = $connection->prepare($sql);
        
        //bind the id to the PDO id
        $statement->bindValue(':id', $id);
        
        // now execute the statement
        $statement->execute();
        
        // attach the sql statement to the new work variable so we can access it in the form
        $work = $statement->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOExcpetion $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    // no id, show error
    echo "No id - something went wrong";
    //exit;
};


?>

<?php include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
<p>Task successfully updated.</p>
<?php endif; ?>

<h2>Edit a task</h2>

<form method="post">

<label for="id">ID</label>
<input type="text" name="id" id="id" value="<?php echo escape($work['id']); ?>" >

<label for="taskname">Artist Name</label>
<input type="text" name="taskname" id="taskname" value="<?php echo escape($work['taskname']); ?>">

<label for="duedate">Work Title</label>
<input type="date" name="duedate" id="duedate" value="<?php echo escape($work['duedate']); ?>">

<label for="taskdetails">Work Date</label>
<input type="text" name="taskdetails" id="taskdetails" value="<?php echo escape($work['taskdetails']); ?>">

<input type="submit" name="submit" value="Save">

</form>


<?php include "templates/footer.php"; ?>