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
<title>Captchit | View Records</title>
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
<form method="POST">

<input type="submit" name="viewhos" value="Hospital Details">
<input type="submit" name="viewpol" value="Police Details">
<input type="submit" name="viewfir" value="Fire Details">
<input type="submit" name="viewele" value="Electricity Details">
</form>
</div>
<?php 
if(isset($_POST['viewhos']))
{
	?>
    <table class="table" style="background:#FFFFE6;">
<tr>
<th>Hospital Name</th>
<th>Contact</th>
<th>Email</th>
<th>Address</td>
<th>City</th>
<th>State</th>
<th>Country</th>
</tr>
<?php
	$qh=mysql_query("select * from tbl_hospital where land_mark_id=".$_GET['id']);
		while($rh=mysql_fetch_array($qh))
		{	
				extract($rh);
?>
				<tr>
				<td><?=$hospital_name?></td>
				<td><?=$h_contact?></td>
				<td><?=$h_email?></td>
				<td><?=$h_address?></td>
				<td><?=$h_city?></td>
				<td><?=$h_state?></td>
				<td><?=$h_country?></td>
				</tr>
<?php
		}
?>
</table>
<?php
}
if(isset($_POST['viewpol']))
{
	?>
    <table class="table" style="background:#FFFFE6;">
<tr>
<th>Police Name</th>
<th>Contact</th>
<th>Email</th>
<th>Address</td>
<th>City</th>
<th>State</th>
<th>Country</th>
</tr>
<?php
	$qh=mysql_query("select * from tbl_police where land_mark_id=".$_GET['id']);
		while($rh=mysql_fetch_array($qh))
		{	
				extract($rh);
?>
				<tr>
				<td><?=$police_name?></td>
				<td><?=$p_contact?></td>
				<td><?=$p_email?></td>
				<td><?=$p_address?></td>
				<td><?=$p_city?></td>
				<td><?=$p_state?></td>
				<td><?=$p_country?></td>
                
				</tr>
<?php
		}
?>
</table>
<?php
}
if(isset($_POST['viewfir']))
{
?>	
<table class="table" style="background:#FFFFE6;">
<tr>
<th>Fire Name</th>
<th>Contact</th>
<th>Email</th>
<th>Address</th>
<th>City</th>
<th>State</th>
<th>Country</th>
</tr>

<?php

	$qh=mysql_query("select * from tbl_fire where land_mark_id=".$_GET['id']);
		while($rh=mysql_fetch_array($qh))
		{	
				extract($rh);
?>
				<tr>
				<td><?=$fire_name?></td>
				<td><?=$f_contact?></td>
				<td><?=$f_email?></td>
				<td><?=$f_address?></td>
				<td><?=$f_city?></td>
				<td><?=$f_state?></td>
				<td><?=$f_country?></td>
    			</tr>
<?php
		}
?>
</table>	
<?php		
}
if(isset($_POST['viewele']))
{
?>
<table class="table" style="background:#FFFFE6;">
<tr>
<th>Electricity Name</th>
<th>Contact</th>
<th>Email</th>
<th>Address</th>
<th>City</th>
<th>State</th>
<th>Country</th>
</tr>
<?php

	$qh=mysql_query("select * from tbl_electricity where land_mark_id=".$_GET['id']);
	if(mysql_num_rows($qh)>0)
	{
		while($rh=mysql_fetch_array($qh))
		{	
				extract($rh);
?>
				<tr>
				<td><?=$electricity_name?></td>
				<td><?=$e_contact?></td>
				<td><?=$e_email?></td>
				<td><?=$e_address?></td>
				<td><?=$e_city?></td>
				<td><?=$e_state?></td>
				<td><?=$e_country?></td>
				</tr>
<?php
		}
	}
?>
</table>


<?php
}
?>
</div>
</div>
</body>
</html>