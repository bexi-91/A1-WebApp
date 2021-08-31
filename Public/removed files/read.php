<?php 

// this code will only execute after the submit button is clicked
if (isset($_POST['submit'])) {
	
    // include the config file 
    require "../config.php"; 
    
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
}?>
<?php include "templates/header.php"; ?>

<?php  
    if (isset($_POST['submit'])) {
        //if there are some results
        if ($result && $statement->rowCount() > 0) { ?>
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
            </p>
<?php   
        //echo '<pre>'; var_dump($row); ???
?>

<hr>
<?php }; 
        }; 
    }; 
?>

<form method="post">
<input type="submit" name="Submit" value="View all">
</form>
<?php include "templates/footer.php"; ?>