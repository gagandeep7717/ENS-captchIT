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
<script src="ajax.js"></script>
</head>
<body>

<?php include '../includes/front-header.php';?>

<div class="row-fluid">
<div class="container">

<div class="span12">
<h3>Landmarks</h3>

<?php
if($_SESSION['admin'] == "dadmin")
{
?>
<b>Sorry ! You Don't Have Permission to Manage this Section.</b>
<?php
}
else
{
?>
<?php
if(isset($_POST['btnadd']))
{
	extract($_POST);
	
	if($tlandmark == '')
	{
	?>
        <script>
		 alert("Please Insert Landmark Field");
		</script>
        <?php	
	}
	else
	{
	$q2 = mysql_query("insert into tbl_landmark(landmark) values('$tlandmark')");
	
	if($q2)
	{
		?>
        <script>
		 alert("Landmark Added Successfully");
		</script>
        <?php
	}
	}
	
}
?>
<div class="row-fluid">
<span id="addlandmark" class="text-warning pull-right" style="cursor:pointer" onClick="addlandmark()">
<b><i class="icon icon-plus"></i> Add Landmark</b>
</span>

<span id="addlandmarkform" class="pull-right" style="display:none">
<form id="myForm" method="post">
<input type="text" style="height:25px !important;" name="tlandmark" placeholder="Enter Landmark Name Here">
<button type="submit" name="btnadd" class="btn btn-info" style="margin-top:-10px;">OK</button>
</form>
</span>
</div>
<br>
<div class="row-fluid">
<?php
 $q1 = mysql_query("select * from tbl_landmark order by landmark");
 while($r1 = mysql_fetch_array($q1))
 {
	 extract($r1);
	 
	 ?>
     
     <div class="" style="background:#000;opacity:0.6;padding:10px;margin:5px;border-radius:5px;"> 
	 
	 <span class="label label-info"><?= strtoupper($landmark);?></span>
     
    
     
     <span class="text-error pull-right" style="cursor:pointer;" onClick="delete_record('tbl_landmark','landmarkid','<?= $landmarkid?>')">
     <b>&nbsp;&nbsp;&nbsp;Delete</b></span>
   
    &nbsp;<a href="add_record.php?id=<?=$landmarkid?>"><b><span class="text-success pull-right" style="cursor:pointer;">&nbsp;&nbsp;&nbsp;Add record</span></b></a>
     
     <a href="view_record.php?id=<?=$landmarkid?>"><b><span class="text-primary pull-right" style="cursor:pointer;">View records</span></b></a>
     
     </div>
     
     <div id="ldetails<?= $landmarkid?>">
     </div>
     <?php
 } 

?>
</div>
<?php
}
?>

</div>
</div>
</div>



</body>

</html>