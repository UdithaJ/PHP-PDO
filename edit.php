

<?php
include("connection.php");

session_start();

if (isset($_POST['cancel'])){
    header('location:index.php');
    return;
}


if(isset($_SESSION['name'])){

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        
        $pid =  $_SESSION['pid'];
        $sth = $conn->prepare("SELECT * FROM Profile WHERE profile_id = $pid  ");
        $sth->execute();
        foreach($sth as $row)

        if($_SESSION['user_id'] ==  $row['user_id']){
        $stmt = $conn->prepare("UPDATE Profile SET first_name = :fn, last_name=:ln, email=:em, headline=:he, summary=:su 
        WHERE profile_id = $pid");
    if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['headline']) && !empty($_POST['summary'])){             

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

else{
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('All fields are required!');
    window.location.href='index.php';
    </script>");
}

        }
else{

    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Access denied!');
    window.location.href='index.php';
    </script>");
}
 
}


$id = $_GET["value"];
$sth = $conn->prepare("SELECT * FROM Profile WHERE profile_id = $id  ");
$sth->execute();
foreach($sth as $row)

if($sth->rowCount() > 0){

    echo "Record found";

}else{

    echo "Record does not exists";

}

}

else{

    echo ("<script LANGUAGE='JavaScript'>
    window.alert('You are not logged in!');
    window.location.href='login.php';
    </script>");
}





?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet"type="text/css"href="style.css">
  <title>Uditha Janadara</title>
</head>
<body>

<form method = "post" action = "edit.php">

<input type = "text" placeholder = "First name" value = <?php echo $row['first_name']; ?> id = "fname" name = "fname"> <br>
<input type = "text" placeholder = "Last name" value = <?php echo $row['last_name']; ?>  id = "lname" name = "lname"> <br>
<input type = "text" placeholder = "Email" value = <?php echo $row['email']; ?> id = "email" name = "email"> <br>
<input type = "text" placeholder = "Headline" value = <?php echo $row['headline']; ?> id = "headline" name = "headline"> <br>
<textarea id = "summary" name = "summary" rows="4" cols="50"><?php echo $row['summary']; ?> </textarea><br>
<?php  $_SESSION['pid'] = $_GET["value"]; ?>
<input type = "submit" class="button" onclick  = "checkEmail()"  value = "Update">
<input type = "submit" class="button" name = "cancel" value = "cancel">
</form>

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
