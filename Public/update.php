<?php 
    session_start(); 

    // include the config and common file 
    require "../config.php"; 
    require "common.php";
    
 // This code will run when the complete button is clicked
    if (isset($_GET["id"])) {
        try {
            $connection = new PDO($dsn, $username, $password, $options);
            
            $id = $_GET["id"]; 
            
            $sql = "DELETE FROM works WHERE id = :id";
            
            $statement = $connection->prepare($sql);
            
            $statement->bindValue(':id', $id);
            
            $statement->execute();

            $success = "Congratulations, you completed a task!";
 
        } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
        }
    };

 // This code runs on page load
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM works WHERE userid = :id order by duedate";

        $statement = $connection->prepare($sql);

        $statement->bindValue(':id',$_SESSION['id']);
        
        $statement->execute();
    
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
        }
?>

<?php include "templates/header.php"; ?>

    <div class="block">
        <?php if (isset($_POST['Complete']) && $statement) : ?>
            <div class="card">
                <div class="card-header">
                    <p class="card-header-title">Task successfully completed!</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="block">
        <section class="hero">
            <div class= "hero-body">
                <div class= "container">
                <h2 class="title">My Task List</h2>
                    <?php 
                        if (isset($success)) {
                        echo "<p>" . $success . "</p>";
                        }
                    ?>
                </div>
            </div>
        </section>
    </div>

    <div class="container">
        <div class= "card">
            <?php 
                foreach($result as $row) { 
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th> </th>
                        <th>Task Name </th>
                        <th> Due Date </th>
                        <th> Task Deatils </th>
                        <th> </th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> <a onClick="return confirm('Are you ready to complete this task?');" href='update.php?id=<?php echo $row['id']; ?>'> <button class = "button is-small is-danger is-inverted" >Complete</button></a> </td>
                        <td> <?php echo $row['taskname']; ?> </td>
                        <td><?php echo $row['duedate']; ?> </td>
                        <td><?php echo $row['taskdetails']; ?></td>
                        <td><a href='update_task.php?id=<?php echo $row['id']; ?>'> <button class= "button is-inverted is-small" > Edit</button></a> </td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <?php }; 
            ?>
        </div>
        </br>
    </div>
<?php include "templates/footer.php"; ?>