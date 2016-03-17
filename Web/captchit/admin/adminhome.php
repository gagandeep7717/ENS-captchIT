<?php
@session_start();
@ob_start();

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");
?>
<!DOCTYPE html>
<html>
<head>
<title>Captchit | Admin Home</title>
<meta charset="UTF-8">
<?php include '../includes/front-res.php';?>

</head>
<body>

<?php include '../includes/front-header.php';?>


<div class="row-fluid">
<div class="container">

<div class="span12">

<div class="span3"></div>

<div class="span6">
<br><br>
<h3>Welcome</h3><hr>

</div>

<div class="span3"></div>
        

</div>
</div>
</div>



</body>

</html>