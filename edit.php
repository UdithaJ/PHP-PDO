

<?php
include("connection.php");

require_once "util.php";

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
    if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['headline']) && !empty($_POST['summary'])){             

$stmt->execute(array(
    ':fn' => $_POST['first_name'],
    ':ln' => $_POST['last_name'],
    ':em' => $_POST['email'],
    ':he' => $_POST['headline'],
    ':su' => $_POST['summary'])
  );


  $stmt = $conn->prepare("DELETE FROM Position WHERE profile_id = $pid");
  $stmt->execute();

  $rank = 1;
  for($i=1; $i<=9; $i++) {
  if ( ! isset($_POST['year'.$i]) ) continue;
  if ( ! isset($_POST['desc'.$i]) ) continue;

  $year = $_POST['year'.$i];
  $desc = $_POST['desc'.$i];

  $flag = validatePos();
  if(is_string($flag)){
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('".$flag."');
    window.location.href='index.php';
    </script>");
    return;
  }


$stmt = $conn->prepare('INSERT INTO Position (profile_id,`rank`, year, description) VALUES ( :pid, :rank, :year, :desc)');

$stmt->execute(array(
  ':pid' => $_SESSION['pid'],
  ':rank' => $rank,
  ':year' => $year,
  ':desc' => $desc)
);

$rank++;

} 


$stmt = $conn->prepare("DELETE FROM Education WHERE profile_id = $pid");
$stmt->execute();

insertEdu($conn, $pid);

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
        //retrive positions
// $positions = loadPos($conn,$id);

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

$positions = loadPos($conn,$id);



?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet"type="text/css"href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css"> 

  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <title>Uditha Janadara</title>
</head>
<body>

<form method = "post" action = "edit.php">

<input type = "text" placeholder = "First name" value = <?php echo $row['first_name']; ?> id = "fname" name = "first_name"> <br>
<input type = "text" placeholder = "Last name" value = <?php echo $row['last_name']; ?>  id = "lname" name = "last_name"> <br>
<input type = "text" placeholder = "Email" value = <?php echo $row['email']; ?> id = "email" name = "email"> <br>
<input type = "text" placeholder = "Headline" value = <?php echo $row['headline']; ?> id = "headline" name = "headline"> <br>
<textarea id = "summary" name = "summary" rows="4" cols="50"><?php echo $row['summary']; ?> </textarea><br>
<?php  $_SESSION['pid'] = $_GET["value"]; ?>

<?php


$positions = $conn->prepare("SELECT * FROM Position WHERE profile_id = $id  ORDER BY `rank` ");
$positions->execute();

$educations = $conn->prepare("SELECT * FROM education WHERE profile_id = $id  ORDER BY `rank` ");
$educations->execute();




$pos = 0;
echo('<p>Position: <input type="button" id ="addPos" value="+">'."\n");
echo('<div id="position_fields">'."\n");

foreach($positions as $position){
    $pos++;
    echo('<div id="position'.$pos.'">'."\n");
    echo('<p>Year: <input type  ="text"  name = "year'.$pos.'"');
    echo('value = "'.$position['year'].'" />'."\n");
    echo('<input type = "button" value = "-" ');
    echo('onclick = "$(\'#position'.$pos.'\').remove(); return false;">'."\n");
    echo("</p>\n");
    echo('<textarea name = "desc'.$pos.'" rows = "8" cols = "80">'."\n");
    echo(htmlentities($position['description'])."\n");
    echo("\n</textarea>\n</div>\n");
}   

echo("</div></p>\n");


$edu = 0;
echo('<p>Education: <input type="button" id ="addEdu" value="+">'."\n");
echo('<div id="edu_fields">'."\n");

foreach($educations as $education){
    $edu++;
    $iid = $education['institution_id'];
    $school = $conn->prepare("SELECT name FROM institution WHERE institution_id = $iid");
    $school->execute();
    $iName = $school->fetch(PDO::FETCH_ASSOC);
    echo('<div id="edu'.$edu.'">'."\n");
    echo('<p>Year: <input type  ="text"  name = "edu_year'.$edu.'"');
    echo('value = "'.$education['year'].'" />'."\n");
    echo('<input type = "button" value = "-" ');
    echo('onclick = "$(\'#edu'.$edu.'\').remove(); return false;">'."\n");
    echo("</p>\n");
    echo('<textarea name = "edu_school'.$edu.'" rows = "8" cols = "80">'."\n");
    echo(htmlentities($iName['name'])."\n");
    echo("\n</textarea>\n</div>\n");
}   

echo("</div></p>\n");

?>

<input type = "submit" class="button" onclick  = "checkEmail()"  value = "Save">
<input type = "submit" class="button" name = "cancel" value = "cancel">
</form>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.11.4.js"></script>

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

countPos = <?= $pos ?>;
countEdu = <?= $edu ?>;

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

        // Grab some HTML with hot spots and insert into the DOM
        var source  = $("#edu-template").html();
        $('#edu_fields').append(source.replace(/@COUNT@/g,countEdu));

        // Add the even handler to the new ones
        $('.school').autocomplete({source: "school.php"});

    });

    $('.school').autocomplete({source: "school.php"});

});

</script>

<script id="edu-template" type="text">
  <div id="edu@COUNT@">
    <p>Year: <input type="text" name="edu_year@COUNT@" value="" />
    <input type="button" value="-" onclick="$('#edu@COUNT@').remove();return false;"><br>
    <p>School: <input type="text" size="80" name="edu_school@COUNT@" class="school" value="" />
    </p>
  </div>
</script>
</div>

</body>
</html>
