<?php

@session_start();
@ob_start();

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");

$hospital_name="";
$h_email='';
$h_contact='';
$h_country='';
$h_state='';
$h_city='';
$h_address='';
$landid='';
	if(isset($_GET['id']))
	{
		$landid=$_GET['id'];
	}

	if(isset($_POST['btnhsave']))
	{
	
		extract($_POST);
	
		$q1 = mysql_query("INSERT INTO `captchit_main_database`.`tbl_hospital` (`hospital_name`, `h_contact`, `h_email`, `h_address`,`h_city`, `h_state`, `h_country`, `land_mark_id`) VALUES ('$thname', '$thcnct', '$themail', '$thaddr', '$thcity', '$thstate', '$thcountry', '$landid')");
	
		if($q1==1)
		{
			echo "inserted";
		}
		else
		{
			echo "Not inserted";
	
		}
	}
	if(isset($_POST['btnhedit']))
	{
		extract($_POST);
	
		$q1 = mysql_query("update tbl_hospital set hospital_name='$thname', h_contact='$thcnct', h_address='$thaddr', h_email='$themail', h_city='$thcity', h_state='$thstate', h_country='$thcountry', land_mark_id='$landid' where hospital_id=".$_GET['aid']);
	
	if($q1==1)
	{
		header("location:hospital.php?id=".$_GET['id']);
	}
	else
	{
	echo "Not inserted";
	
	}
}
if(isset($_GET['aid']))
{
	$s=mysql_query("select * from tbl_hospital where hospital_id=".$_GET['aid']);
	while($rs=mysql_fetch_array($s))
	{
		extract($rs);
	}
}
if(isset($_GET['did']))
{
	$d=mysql_query("delete from tbl_hospital where hospital_id=".$_GET['did']);
	
}
$qw=mysql_query("select * from tbl_landmark where landmarkid=".$_GET['id']);

while($rw=mysql_fetch_array($qw))
{
	extract($rw);
	
}
?>
<style>
a
{
	text-decoration:none !important;	
}
</style>
<!DOCTYPE html>
<html>
<head>
<title>Captchit | Add Records</title>
<meta charset="UTF-8">
<?php include '../includes/front-res.php';?>
<script src="ajax.js"></script>
</head>
<body>

<?php include '../includes/front-header.php';?>

<div class="row-fluid">
<div class="container">

<div class="span12">
<h3><?=ucfirst($landmark)?></h3>

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


<div class="span12" id="hospital" >
<h4>Hospital Details</h4>
<div class="span3"></div>
<div class="span6">
<form method="POST">

 		<input type="text" name="thname"  id="thname" placeholder="Hospital Name" value="<?=$hospital_name?>" style="width:90%"/><br />
		<input type="text" name="thcnct" maxlength="12" id="thcnct" placeholder="Contact Number" value="<?=$h_contact?>"/>
       <input type="text" name="themail"  id="themail" placeholder="Email Id" value="<?=$h_email?>" /><br />
       <input type="text" name="thaddr" id="thaddr" placeholder="Address" value="<?=$h_address?>" />
      
       <input type="text" name="thcity" id="thcity" placeholder="City" value="<?=$h_city?>" /><br />
       <input type="text" name="thstate" id="thstate" placeholder="State" value="<?=$h_state?>" />
       <input type="text" name="thcountry" id="thcountry" placeholder="Country" value="<?=$h_country?>"/><br />
       <center>
       <?php
	   if(isset($_GET['aid']))
	   {
		?>
		  <input type="submit" class="btn btn-info" name="btnhedit" value="Update" /> 
           
		<?php
        }
		else
		{
	   ?>
       <input type="submit" class="btn btn-info" name="btnhsave" value="Save" />
      
       <?php
		}
	   ?>
       </center>
      </form>

</div>
<div class="span3"></div>
<table class="table" style="background:#FFFFE6;">
<tr>
<th>Hospital Name</th>
<th>Contact</th>
<th>Email</th>
<th>Address</td>
<th>City</th>
<th>State</th>
<th>Country</th>
<th></th>
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
                <td>
                <a href="hospital.php?aid=<?=$hospital_id?>&id=<?=$land_mark_id?>" style="text-decoration:none">
                <b>&nbsp;&nbsp;&nbsp;<i class="icon icon-edit" title="Edit"></i>
                </b>
                </a>
                    <a href="hospital.php?did=<?=$hospital_id?>&id=<?=$land_mark_id?>" style="text-decoration:none">
                    <b>&nbsp;&nbsp;&nbsp;<i class="icon icon-trash" title="Delete"></i>
                    </b></a></td>
				</tr>
<?php
		}
?>
</table>
</div>
</div>
</div>
</body>
</html>