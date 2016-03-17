<?php

@session_start();
@ob_start();

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");

$fire_name="";
$f_email='';
$f_contact='';
$f_country='';
$f_state='';
$f_city='';
$f_address='';
$landid='';
	if(isset($_GET['id']))
	{
		$landid=$_GET['id'];
	}

	if(isset($_POST['btnfsave']))
	{
	
		extract($_POST);
	
		$q1 = mysql_query("INSERT INTO `captchit_main_database`.`tbl_fire` (`fire_name`, `f_contact`, `f_email`, `f_address`,`f_city`, `f_state`, `f_country`, `land_mark_id`) VALUES ('$tfname', '$tfcnct', '$tfemail', '$tfaddr', '$tfcity', '$tfstate', '$tfcountry', '$landid')");
	
		if($q1==1)
		{
			echo "inserted";
		}
		else
		{
			echo "Not inserted";
	
		}
	}
	if(isset($_POST['btnfedit']))
	{
		extract($_POST);
	
		$q1 = mysql_query("update tbl_fire set fire_name='$tfname', f_contact='$tfcnct', f_address='$tfaddr', f_email='$tfemail', f_city='$tfcity', f_state='$tfstate', f_country='$tfcountry', land_mark_id='$landid' where fire_id=".$_GET['aid']);
	
	if($q1==1)
	{
		header("location:firedetails.php?id=".$_GET['id']);
	}
	else
	{
	echo "Not inserted";
	
	}
}
if(isset($_GET['aid']))
{
	$s=mysql_query("select * from tbl_fire where fire_id=".$_GET['aid']);
	while($rs=mysql_fetch_array($s))
	{
		extract($rs);
	}
}
if(isset($_GET['did']))
{
	$d=mysql_query("delete from tbl_fire where fire_id=".$_GET['did']);
	
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


<div class="span12" id="police" >
<h4>Police Details</h4>
<div class="span3"></div>
<div class="span6">
<form method="POST">

 		<input type="text" name="tfname"  id="tfname" placeholder="Fireman Name" value="<?=$fire_name?>" style="width:90%"/><br />
		<input type="text" name="tfcnct" maxlength="12" id="tfcnct" placeholder="Contact Number" value="<?=$f_contact?>"/>
       <input type="text" name="tfemail"  id="tfemail" placeholder="Email Id" value="<?=$f_email?>" /><br />
       <input type="text" name="tfaddr" id="tfaddr" placeholder="Address" value="<?=$f_address?>" />
      
       <input type="text" name="tfcity" id="tfcity" placeholder="City" value="<?=$f_city?>" /><br />
       <input type="text" name="tfstate" id="tfstate" placeholder="State" value="<?=$f_state?>" />
       <input type="text" name="tfcountry" id="tfcountry" placeholder="Country" value="<?=$f_country?>"/><br />
       <center>
       <?php
	   if(isset($_GET['aid']))
	   {
		?>
		  <input type="submit" class="btn btn-info" name="btnfedit" value="Update" /> 
           
		<?php
        }
		else
		{
	   ?>
       <input type="submit" class="btn btn-info" name="btnfsave" value="Save" />
      
       <?php
		}
	   ?>
       </center>
      </form>

</div>
<div class="span3"></div>
<table class="table" style="background:#FFFFE6;">
<tr>
<th>Fire Name</th>
<th>Contact</th>
<th>Email</th>
<th>Address</th>
<th>City</th>
<th>State</th>
<th>Country</th>
<th></th>
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
                <td>
                <a href="firedetails.php?aid=<?=$fire_id?>&id=<?=$land_mark_id?>" style="text-decoration:none">
                <b>&nbsp;&nbsp;&nbsp;<i class="icon icon-edit" title="Edit"></i>
                </b>
                </a>
                    <a href="firedetails.php?did=<?=$fire_id?>&id=<?=$land_mark_id?>" style="text-decoration:none">
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