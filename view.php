

<?php
include("connection.php");

session_start();


$id = $_GET["value"];
$sth = $conn->prepare("SELECT * FROM Profile WHERE profile_id = $id  ");
$sth->execute();
foreach($sth as $row)



?>


<!DOCTYPE html>
<html>
<head>
  <title>Uditha Janadara</title>
</head>
<body>

<p>First Name:
<?php echo $row['first_name']; ?></p>
<p>Last Name:
<?php echo $row['last_name']; ?> </p> 
<p>Email:
<?php echo $row['email']; ?> </p>
<p>Headline:
<?php echo $row['headline']; ?></p>
<p>Summary:
<?php echo $row['summary']; ?> </p>
</p>
<a href="index.php" >Done</a>



</body>
</html>
