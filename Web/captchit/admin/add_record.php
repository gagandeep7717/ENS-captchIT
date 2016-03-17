<?php
@session_start();
@ob_start();

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");

$landid='';
if(isset($_GET['id']))
{
$landid=$_GET['id'];

$qw=mysql_query("select * from tbl_landmark where landmarkid=".$_GET['id']);

while($rw=mysql_fetch_array($qw))
{
	extract($rw);
	
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Captchit | Add Records</title>
<meta charset="UTF-8">
<?php include '../includes/front-res.php';?>
<script src="ajax.js"></script>
<style>
a
{
	text-decoration:none !important;	
}
</style>
</head>
<body>

<?php include '../includes/front-header.php';?>

<div class="row-fluid">
<div class="container">

<div class="span12">
<h3><?=$landmark?></h3>
<a href="hospital.php?id=<?=$_GET['id']?>">
<button type="button" name="btnhos" id="btnhos">Hospital details</button>
</a>

<a href="policedetails.php?id=<?=$_GET['id']?>">
<button type="button" name="btnpol" id="btnpol">Police details</button>
</a>

<a href="firedetails.php?id=<?=$_GET['id']?>">
<button type="button" name="btnfir" id="btnfir">Fire details</button>
</a>

<a href="electricitydetails.php?id=<?=$_GET['id']?>">
<button type="button" name="btnele" id="btnele">Electricity details</button>
</a>

</div>

</div>
</div>
</body>
</html>