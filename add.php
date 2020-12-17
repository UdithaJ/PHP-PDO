<!DOCTYPE html>
<html>
<head>
  <title>Uditha Janadara</title>
  <link rel="stylesheet"type="text/css"href="style.css">
</head>
<body>

<form method = "post" action = "add.php">

<input type = "text" placeholder = "First name" id = "fname" name = "fname"> <br>
<input type = "text" placeholder = "Last name" id = "lname" name = "lname"> <br>
<input type = "text" placeholder = "Email" id = "email" name = "email"> <br>
<input type = "text" placeholder = "Headline" id = "headline" name = "headline"> <br>
<textarea id = "summary" name = "summary" rows="4" cols="50"></textarea><br>
<input type = "submit" class="button" onclick  = "checkEmail()" value = "Add">
<input type = "submit"  class="button" name = "cancel" value = "cancel">
</form>

<?php
 session_start();
$conn = new PDO ('mysql:host=localhost;dbname=coursera','root','mysql');
$stmt = $conn->prepare('INSERT INTO Profile(user_id, first_name, last_name, email, headline, summary)
                        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
 if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
   
if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['headline']) && !empty($_POST['summary'])){

$stmt->execute(array(
  ':uid' => $_SESSION['user_id'],
  ':fn' => $_POST['fname'],
  ':ln' => $_POST['lname'],
  ':em' => $_POST['email'],
  ':he' => $_POST['headline'],
  ':su' => $_POST['summary'])
);
header("Location: index.php");
        return;
}

else{
  echo ("<script LANGUAGE='JavaScript'>
  window.alert('All fields are required!');
  window.location.href='index.php';
  </script>");
}
 }
?>


<script>
function checkEmail(){

    mail = document.getElementById('email').value;
    if(mail.indexOf('@') == -1){
        alert('Invalid email address');
        return false;
    }
}
</script>

</body>

</html>