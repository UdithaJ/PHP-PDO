
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

        $stmt = $conn->prepare("DELETE FROM Profile WHERE profile_id = $pid");

        if($_SESSION['user_id'] ==  $row['user_id']){

        $stmt->execute();      
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Succesfully Deleted!');
        window.location.href='index.php';
        </script>");
        }
        
        else{

            header("Location: login.php");
            return;
        }

    
 
}
}

else{

    echo ("<script LANGUAGE='JavaScript'>
    window.alert('You are not logged in!');
    window.location.href='index.php';
    </script>");
}


    $id = $_GET["value"];
    $sth = $conn->prepare("SELECT * FROM Profile WHERE profile_id = $id  ");
    $sth->execute();

    if($sth->rowCount() > 0){

        echo "Record found";
    
    }else{
    
        echo "Record does not exists";
    
    }

    foreach($sth as $row)
    


?>




<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet"type="text/css"href="style.css">
  <title>Uditha Janadara</title>
</head>
<body>

<form method = "post" action = "delete.php">

<input type = "text" placeholder = "First name" value = <?php echo $row['first_name']; ?> id = "fname" name = "fname"> <br>
<input type = "text" placeholder = "Last name" value = <?php echo $row['last_name']; ?>  id = "lname" name = "lname"> <br>
<?php  $_SESSION['pid'] = $_GET["value"]; ?>
<input type = "submit"  class="button" value = "Delete">
<input type = "submit"  class="button" name = "cancel" value = "cancel">

</form>


<script>
function deleteSuccess(){
alert('Successfuly deleted!');
}
</script>

</body>

</html>