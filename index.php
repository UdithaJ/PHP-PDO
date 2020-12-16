
<?php
include("connection.php");

session_start();
// $query = "SELECT * FROM Profile";
// $result  = mysqli_query($conn,"SELECT * FROM Profile");
$sth = $conn->prepare("SELECT * FROM Profile");
$sth->execute();

if(isset($_SESSION['name'])){
    echo $_SESSION['name'];
    echo "<script> window.onload = function() {
       activate();
       showLink();
    }; </script>";
 
}
?>






<!DOCTYPE html>
<html>
<body>

<table>
<tr>
<th>ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Action</th>
</tr>
<?php
foreach($sth as $row)
{
?>
<tr>

<td><?php echo $row['first_name']; ?></td>
<td><?php echo $row['last_name']; ?></td>
<div id = "edit" style="display:none">
<!-- <td><a href="edit.php" >edit</a> <a href="login.php" >delete</a></td> -->
<td><?php echo"<a href=\"edit.php?value=" . urlencode($row['profile_id'])."\">".'Edit'."</a>"; echo" <a href=\"delete.php?value=" . urlencode($row['profile_id'])."\">".'Delete'."</a>"; ?></td>

</div>
</tr>
<?php
}
?>
</table>

<br>
<a href="login.php" id = "link">Log In</a>
<a href="add.php" id = "add" style="display:none">Add New</a>



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

