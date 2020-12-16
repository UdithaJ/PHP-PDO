<!DOCTYPE html>
<html>
<body>

<form method = "post" action = "add.php">

<input type = "text" placeholder = "First name" id = "fname" name = "fname"> <br>
<input type = "text" placeholder = "Last name" id = "lname" name = "lname"> <br>
<input type = "text" placeholder = "Email" id = "email" name = "email"> <br>
<input type = "text" placeholder = "Headline" id = "headline" name = "headline"> <br>
<textarea id = "summary" name = "summary" rows="4" cols="50"></textarea><br>
<input type = "submit" value = "Add">
<input type = "submit" name = "cancel" value = "cancel">
</form>

<?php
 session_start();
$conn = new PDO ('mysql:host=localhost;dbname=coursera','root','mysql');
$stmt = $conn->prepare('INSERT INTO Profile(user_id, first_name, last_name, email, headline, summary)
                        VALUES ( :uid, :fn, :ln, :em, :he, :su)');

if(isset($_POST['fname']) && isset($_POST['lname'])){

$stmt->execute(array(
  ':uid' => $_SESSION['user_id'],
  ':fn' => $_POST['fname'],
  ':ln' => $_POST['lname'],
  ':em' => $_POST['email'],
  ':he' => $_POST['headline'],
  ':su' => $_POST['summary'])
);
}
?>

</body>

</html>