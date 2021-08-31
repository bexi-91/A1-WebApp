<?php 
 // include the config file 
 require "../config.php";
 require "common.php";

 // This code will only run if the delete button is clicked
 if (isset($_GET["id"])) {
     // this is called a try/catch statement 
     try {
         // define database connection
         $connection = new PDO($dsn, $username, $password, $options);
         
         // set id variable
         $id = $_GET["id"];
         
         // Create the SQL 
         $sql = "DELETE FROM works WHERE id = :id";

        $onclick = confirm('are you sure?');

         // Prepare the SQL
         $statement = $connection->prepare($sql);
         
         // bind the id to the PDO
         $statement->bindValue(':id', $id);
         
         // execute the statement
         $statement->execute();

         // Success message
         $success = "Congratulations, you completed a task!";

     } catch(PDOException $error) {
         // if there is an error, tell us what it is
         echo $sql . "<br>" . $error->getMessage();
     }
 };

 // This code runs on page load
 try {
     $connection = new PDO($dsn, $username, $password, $options);
     
     // SECOND: Create the SQL 
     $sql = "SELECT * FROM works";
     
     // THIRD: Prepare the SQL
     $statement = $connection->prepare($sql);
     $statement->execute();
     
     // FOURTH: Put it into a $result object that we can access in the page
     $result = $statement->fetchAll();
 } catch(PDOException $error) {
     echo $sql . "<br>" . $error->getMessage();
 }

 
?>
<?php include "templates/header.php"; ?>

            <h2>My Task List</h2>

            <?php 
                  foreach($result as $row) { 
            ?>

            <p>
                Task Name:
                <?php echo $row['taskname']; ?><br> 

                Due Date:
                <?php echo $row['duedate']; ?><br> 

                Task Details:
                <?php echo $row['taskdetails']; ?><br> 

               <a href='delete.php?id=<?php echo $row['id']; ?>'> <button onclick="confirmAction('Are you sure?')">Complete</button></a>
            
            </p>


<hr>
<?php }; 

?>

<form method="post">
<input type="submit" name="Submit" value="View all">
</form>
<?php include "templates/footer.php"; ?>