<?php 
    // include the config file 
    require "../config.php"; 
    require "common.php";
    
	try {
        $connection = new PDO($dsn, $username, $password, $options);
		
        $sql = "SELECT * FROM works";
        
        $statement = $connection->prepare($sql);
        $statement->execute();
        
        $result = $statement->fetchAll();

	} catch(PDOException $error) {
        // if there is an error, tell us what it is
		echo $sql . "<br>" . $error->getMessage();
	}	
?>
<?php include "templates/header.php"; ?>

            <h2>To-do</h2>

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

               <a href='update_task.php?id=<?php echo $row['id']; ?>'>Edit</a>
            </p>


<hr>
<?php }; 

?>

<form method="post">
<input type="submit" name="Submit" value="View all">
</form>
<?php include "templates/footer.php"; ?>