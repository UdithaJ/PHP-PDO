
<?php
include("connection.php");

session_start();
// $query = "SELECT * FROM Profile";
// $result  = mysqli_query($conn,"SELECT * FROM Profile");

if(isset($_SESSION['name'])){
  $id = $_SESSION['user_id'] ;
  $sth = $conn->prepare("SELECT * FROM Profile WHERE user_id = $id ");
  $sth->execute();
    echo 'Welcome ' .$_SESSION['name'];
    echo "<script> window.onload = function() {
       activate();
       showLink();
    }; </script>";
 
}

$sth = $conn->prepare("SELECT * FROM Profile");
$sth->execute();
?>






<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet"type="text/css"href="style.css">
  <title>Uditha Janadara</title>
</head>
<body>

<table>
<tr>
<th>Name</th>
<th>Headline</th>
<th>Action</th>
</tr>
<?php
foreach($sth as $row)
{
?>
<tr>

<td><?php echo"<a href=\"view.php?value=" . urlencode($row['profile_id'])."\">".$row['first_name']. " " .$row['last_name']."</a>"; ?> </td>
<td><?php echo $row['headline']; ?></td>
<td><?php echo"<a href=\"edit.php?value=" . urlencode($row['profile_id'])."\">".'Edit'."</a>"; echo" <a href=\"delete.php?value=" . urlencode($row['profile_id'])."\">".'Delete'."</a>"; ?></td>


</tr>
<?php
}
?>
</table>

<br>
<a href="login.php" class="button" id = "link">Please log in</a>
<p><a href="login.php">Please log in</a></p>
<a href="add.php" class="button" id = "add" style="display:none">Add New</a>



<script>
function activate(){
var link = document.getElementById('link');
link.setAttribute('href', 'logout.php');
document.getElementById('link').innerHTML = "Logout";
}
</script>

<script>
function showLink() {
  var link = document.getElementById("add");
  var edit = document.getElementById("edit");
  link.style.display = "block";
  edit.style.display = "block";
  
}
</script>

</body>
</html>

