<?php

@session_start();
@ob_start();

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");

$electricity_name="";
$e_email='';
$e_contact='';
$e_country='';
$e_state='';
$e_city='';
$e_address='';
$landid='';
	if(isset($_GET['id']))
	{
		$landid=$_GET['id'];
	}

	if(isset($_POST['btnesave']))
	{
	
		extract($_POST);
	
		$q1 = mysql_query("INSERT INTO `captchit_main_database`.`tbl_electricity` (`electricity_name`, `e_contact`, `e_email`, `e_address`,`e_city`, `e_state`, `e_country`, `land_mark_id`) VALUES ('$tename', '$tecnct', '$teemail', '$teaddr', '$tecity', '$testate', '$tecountry', '$landid')");
	
		if($q1==1)
		{
			echo "inserted";
		}
		else
		{
			echo "Not inserted";
	
		}
	}
	if(isset($_POST['btneedit']))
	{
		extract($_POST);
	
		$q1 = mysql_query("update tbl_electricity set electricity_name='$tename', e_contact='$tecnct', e_address='$teaddr', e_email='$teemail', e_city='$tecity', e_state='$testate', e_country='$tecountry', land_mark_id='$landid' where electricity_id=".$_GET['aid']);
	
	if($q1==1)
	{
		header("location:electricitydetails.php?id=".$_GET['id']);
	}
	else
	{
	echo "Not inserted";
	
	}
}
if(isset($_GET['aid']))
{
	$s=mysql_query("select * from tbl_electricity where electricity_id=".$_GET['aid']);
	while($rs=mysql_fetch_array($s))
	{
		extract($rs);
	}
}
if(isset($_GET['did']))
{
	$d=mysql_query("delete from tbl_electricity where electricity_id=".$_GET['did']);
	
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
<h4>Electricity Details</h4>
<div class="span3"></div>
<div class="span6">
<form method="POST">

 		<input type="text" name="tename"  id="tename" placeholder="Electricity Name" value="<?=$electricity_name?>" style="width:90%"/><br />
		<input type="text" name="tecnct" maxlength="12" id="tecnct" placeholder="Contact Number" value="<?=$e_contact?>"/>
       <input type="text" name="teemail"  id="teemail" placeholder="Email Id" value="<?=$e_email?>" /><br />
       <input type="text" name="teaddr" id="teaddr" placeholder="Address" value="<?=$e_address?>" />
      
       <input type="text" name="tecity" id="tecity" placeholder="City" value="<?=$e_city?>" /><br />
       <input type="text" name="testate" id="testate" placeholder="State" value="<?=$e_state?>" />
       <input type="text" name="tecountry" id="tehcountry" placeholder="Country" value="<?=$e_country?>"/><br />
       <center>
       <?php
	   if(isset($_GET['aid']))
	   {
		?>
		  <input type="submit" class="btn btn-info" name="btneedit" value="Update" /> 
           
		<?php
        }
		else
		{
	   ?>
       <input type="submit" class="btn btn-info" name="btnesave" value="Save" />
      
       <?php
		}
	   ?>
       </center>
      </form>

</div>
<div class="span3"></div>
<table class="table" style="background:#FFFFE6;">
<tr>
<th>Electricity Name</th>
<th>Contact</th>
<th>Email</th>
<th>Address</th>
<th>City</th>
<th>State</th>
<th>Country</th>
<th></th>
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
                <td>
                <a href="electricitydetails.php?aid=<?=$electricity_id?>&id=<?=$land_mark_id?>" style="text-decoration:none">
                <b>&nbsp;&nbsp;&nbsp;<i class="icon icon-edit" title="Edit"></i>
                </b>
                </a>
                    <a href="electricitydetails.php?did=<?=$electricity_id?>&id=<?=$land_mark_id?>" style="text-decoration:none">
                    <b>&nbsp;&nbsp;&nbsp;<i class="icon icon-trash" title="Delete"></i>
                    </b></a></td>
				</tr>
<?php
		}
	}
?>
</table>
</div>
</div>
</div>
</body>
</html>