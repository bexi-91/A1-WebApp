<?php 
// include the config and common file
require "../config.php";
require "common.php";

// run when submit button is clicked
if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);  
        
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
                    taskdetails = :taskdetails 
                WHERE id = :id";

        $statement = $connection->prepare($sql);
        
        $statement->execute($work);

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

// GET data from DB
if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $id = $_GET['id'];
        
        $sql = "SELECT * FROM works WHERE id = :id";
        
        $statement = $connection->prepare($sql);
        
        $statement->bindValue(':id', $id);
        
        $statement->execute();
        
        $work = $statement->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOExcpetion $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "No id - something went wrong";
};
?>

<?php include "templates/header.php"; ?>
    
    <div class="block">
        <section class="hero">
            <div class= "hero-body">
                <div class= "container">
                    <h2 class="title">Edit a task</h2>
                </div>
            </div>
        </section>
    </div>

    <?php if (isset($_POST['submit']) && $statement) { ?>
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    Task successfully updated!
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    <p> <a href="update.php"> Back to my list </a> </p> 
                </div>
            </div>
        </div>
        <?php } ?>

    <div class="block">
        <form method="post">
            <div class="column">
                <input type="hidden" class="input" name="id" id="id" value="<?php echo escape($work['id']); ?>">
            </div>

            <div class="column">
                <label for="taskname">Task Name</label>
                <input type="text" class="input" name="taskname" id="taskname" value="<?php echo escape($work['taskname']); ?>">
             </div>
            
            <div class="column">
                <label for="duedate">Due Date</label>
                <input type="date" class="input" name="duedate" id="duedate" value="<?php echo escape($work['duedate']); ?>">
            </div>

            <div class="column">
                <label for="taskdetails">Task Details</label>
                <input type="text" class="input" name="taskdetails" id="taskdetails" value="<?php echo escape($work['taskdetails']); ?>">
            </div>

            <div class="column">
                <input class= "button is-link is-small" type="submit" name="submit" value="Save">
            </div>
        </form>
    </div>
<?php include "templates/footer.php"; ?>