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
<title>Captchit | Admin Complaints</title>
<meta charset="UTF-8">
<script src="ajax.js"></script>
<?php include '../includes/front-res.php';?>

</head>
<body onLoad="getComplaint()">

<?php include '../includes/front-header.php';?>
<?php
if(isset($_GET['compid']))
{
	$q = mysql_query("update tbl_complaint set status='1' where id=".$_GET['compid']);
	if($q)
	{
		?>
        <script>
		alert("Complaint's Status Changed Successfully !!!");
		</script>
        <?php
		
	}
}
?>

<div class="row-fluid">
<div class="container">


<b>Search by Type: </b>
<select name="comptype" id="comptype" onChange="searchcomp()">
<option value="All">All Complaints</option>
<option value="Accident">Accident</option>
<option value="Fire">Fire</option>
<option value="Electric Problem">Electric Problem</option>
<option value="Crime Activity">Crime Activity</option>
</select>

<div class="span12" id="complaintgrid">



</div>
</div>
</div>



</body>

</html>