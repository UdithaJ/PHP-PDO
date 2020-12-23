<?php

require_once "util.php";

 session_start();
$conn = new PDO ('mysql:host=localhost;dbname=coursera','root','mysql');
$stmt = $conn->prepare('INSERT INTO Profile(user_id, first_name, last_name, email, headline, summary)
                        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
 if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
   
if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['headline']) && !empty($_POST['summary'])){

$stmt->execute(array(
  ':uid' => $_SESSION['user_id'],
  ':fn' => $_POST['first_name'],
  ':ln' => $_POST['last_name'],
  ':em' => $_POST['email'],
  ':he' => $_POST['headline'],
  ':su' => $_POST['summary'])
);
$profile_id = $conn->lastInsertId();

$rank = 1;
for($i=1; $i<=9; $i++) {
  if ( ! isset($_POST['year'.$i]) ) continue;
  if ( ! isset($_POST['desc'.$i]) ) continue;

  $year = $_POST['year'.$i];
  $desc = $_POST['desc'.$i];

  $flag = validatePos();
  if(is_string($flag)){
    header('location:index.php');
    echo "error";
    return;
  }

  insertEdu($conn,$profile_id);

$stmt2 = $conn->prepare('INSERT INTO Position (profile_id,`rank`, year, description) VALUES ( :pid, :rank, :year, :desc)');

$stmt2->execute(array(
  ':pid' => $profile_id,
  ':rank' => $rank,
  ':year' => $year,
  ':desc' => $desc)
);

$rank++;

} 


header('location:index.php');
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




<!DOCTYPE html>
<html>
<head>
  <title>Uditha Janadara</title>

  <link rel="stylesheet"type="text/css"href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css"> 

  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

</head>
<body>

<form method = "post" action = "add.php">

<input type = "text" placeholder = "First name" id = "first_name" name = "first_name"> <br>
<input type = "text" placeholder = "Last name" id = "last_name" name = "last_name"> <br>
<input type = "text" placeholder = "Email" id = "email" name = "email"> <br>
<input type = "text" placeholder = "Headline" id = "headline" name = "headline"> <br>
<textarea id = "summary" name = "summary" rows="4" cols="50"></textarea><br>
<p>
Education: <input type="button" id="addEdu" value="+">
<div id="edu_fields">
</div>
</p>
<p>
Position: <input type="button" id="addPos" value="+">
<div id="position_fields">
</div>
</p>
<p>

<input type = "submit" class="button" onclick  = "checkEmail()" value = "Add">
<input type = "submit"  class="button" name = "cancel" value = "cancel">
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



<script>
countPos = 0;
countEdu = 0;

// http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript
$(document).ready(function(){
    window.console && console.log('Document ready called');

    $('#addPos').click(function(event){
        // http://api.jquery.com/event.preventdefault/
        event.preventDefault();
        if ( countPos >= 9 ) {
            alert("Maximum of nine position entries exceeded");
            return;
        }
        countPos++;
        window.console && console.log("Adding position "+countPos);
        $('#position_fields').append(
            '<div id="position'+countPos+'"> \
            <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
            <input type="button" value="-" \
                onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
            <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
    });

    $('#addEdu').click(function(event){
        event.preventDefault();
        if ( countEdu >= 9 ) {
            alert("Maximum of nine education entries exceeded");
            return;
        }
        countEdu++;
        window.console && console.log("Adding education "+countEdu);

        $('#edu_fields').append(
            '<div id="edu'+countEdu+'"> \
            <p>Year: <input type="text" name="edu_year'+countEdu+'" value="" /> \
            <input type="button" value="-" onclick="$(\'#edu'+countEdu+'\').remove();return false;"><br>\
            <p>School: <input type="text" size="80" name="edu_school'+countEdu+'" class="school" value="" />\
            </p></div>'
        );

        $('.school').autocomplete({ source: "school.php" });
    });

});
</script>

</div>
</body>

</html>