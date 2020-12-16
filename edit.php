

<?php
include("connection.php");

session_start();


if(isset($_SESSION['name'])){

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $pid =  $_SESSION['pid'];
    if(isset($_POST['fname']) || isset($_POST['lname'])|| isset($_POST['email'])|| isset($_POST['headline'])){
        $stmt = $conn->prepare("UPDATE Profile SET first_name = :fn, last_name=:ln, email=:em, headline=:he, summary=:su 
        WHERE profile_id = $pid");
                      

$stmt->execute(array(
    ':fn' => $_POST['fname'],
    ':ln' => $_POST['lname'],
    ':em' => $_POST['email'],
    ':he' => $_POST['headline'],
    ':su' => $_POST['summary'])
  );
  header("Location: index.php");

    return;
    }
 
}
}

    
    $id = $_GET["value"];
    $sth = $conn->prepare("SELECT * FROM Profile WHERE profile_id = $id  ");
    $sth->execute();
    foreach($sth as $row)


?>


<!DOCTYPE html>
<html>
<body>

<form method = "post" action = "edit.php">

<input type = "text" placeholder = "First name" value = <?php echo $row['first_name']; ?> id = "fname" name = "fname"> <br>
<input type = "text" placeholder = "Last name" value = <?php echo $row['last_name']; ?>  id = "lname" name = "lname"> <br>
<input type = "text" placeholder = "Email" value = <?php echo $row['email']; ?> id = "email" name = "email"> <br>
<input type = "text" placeholder = "Headline" value = <?php echo $row['headline']; ?> id = "headline" name = "headline"> <br>
<textarea id = "summary" name = "summary" rows="4" cols="50"><?php echo $row['summary']; ?> </textarea><br>
<?php  $_SESSION['pid'] = $_GET["value"]; ?>
<input type = "submit" value = "Update">
<input type = "submit" name = "cancel" value = "cancel">
</form>


</body>
</html>
