    <?php
    include("connection.php");
    // $conn = new PDO ('mysql:host=localhost;dbname=coursera','root','mysql');

    session_start();
    unset($_SESSION['name']);
    unset($_SESSION['user_ID']);

    if (isset($_POST['cancel'])){
        header('location:index.php');
        return;
    }

    $salt = 'XyZzy12*_';

    if(isset($_POST['email']) && isset($_POST['password'])){
        
        if(strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1){
            $_SESSION['error'] = "Email and Password are required";
            header("location:login.php");
            return;
        }
    }
     $check = hash('md5', $salt.$_POST['password']);

     $stmt = $conn->prepare('SELECT user_id, name FROM users
     WHERE email = :em AND password = :pw');

     $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));

     $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ( $row !== false ) {


    $_SESSION['name'] = $row['name'];

    $_SESSION['user_id'] = $row['user_id'];

    // Redirect the browser to index.php

    header("Location: index.php");

    return;
    }

    // else{

    //     header("Location: login.php");

    //     return ;
    // }

?>

<!DOCTYPE html>
<html>
<body>

<form method = "post" action = "login.php">

<input type = "text" placeholder = "Email" id = "email" name = "email"> <br>
<input type = "text" placeholder = "password" id = "password" name = "password"> <br>
<input type = "submit" onclick = "doValidate()" value = "login">
<input type = "submit" name = "cancel" value = "cancel">

</form>

<script>
function doValidate(){
try{
    mail = document.getElementById('email').value;
    pass = document.getElementById('password').value;

    if(mail == null|| mail == "" || pass == null || pass == "")
    {
        alert('Both fields must be filled out');
        return false;
    }

    if(mail.indexOf('@') == -1){
        alert('Invalid email address');
        return false;
    }
    return true;
} catch(e){
    return false;
}
return false;
}
</script>

</body>

</html>