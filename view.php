

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
<?php


$positions = $conn->prepare("SELECT * FROM Position WHERE profile_id = $id  ORDER BY `rank` ");
$positions->execute();


$pos = 0;

foreach($positions as $position){
    $pos++;
    echo('<div id="position'.$pos.'">'."\n");
    echo "Year:".$position['year']."\n";
    echo "Description:".$position['description']."\n";
    // echo('<p>Year: <p>$position['year']</p> name = "year'.$pos.'"');
    // echo('<p> Description: <p>$position['description']</p> name = ""desc'.$pos.'"'."\n");
}

echo("</div></p>\n");
?>
<a href="index.php" >Done</a>


<script>

countPos = <?= $pos ?>;

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
});
</script>

</body>
</html>
