<?php

@session_start();
@ob_start();

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");

$police_name="";
$p_email='';
$p_contact='';
$p_country='';
$p_state='';
$p_city='';
$p_address='';
$landid='';
	if(isset($_GET['id']))
	{
		$landid=$_GET['id'];
	}

	if(isset($_POST['btnpsave']))
	{
	
		extract($_POST);
	
		$q1 = mysql_query("INSERT INTO `captchit_main_database`.`tbl_police` (`police_name`, `p_contact`, `p_email`, `p_address`,`p_city`, `p_state`, `p_country`, `land_mark_id`) VALUES ('$tpname', '$tpcnct', '$tpemail', '$tpaddr', '$tpcity', '$tpstate', '$tpcountry', '$landid')");
	
		if($q1==1)
		{
			echo "inserted";
		}
		else
		{
			echo "Not inserted";
	
		}
	}
	if(isset($_POST['btnpedit']))
	{
		extract($_POST);
	
		$q1 = mysql_query("update tbl_police set police_name='$tpname', p_contact='$tpcnct', p_address='$tpaddr', p_email='$tpemail', p_city='$tpcity', p_state='$tpstate', p_country='$tpcountry', land_mark_id='$landid' where police_id=".$_GET['aid']);
	
	if($q1==1)
	{
		header("location:policedetails.php?id=".$_GET['id']);
	}
	else
	{
	echo "Not inserted";
	
	}
}
if(isset($_GET['aid']))
{
	$s=mysql_query("select * from tbl_police where police_id=".$_GET['aid']);
	while($rs=mysql_fetch_array($s))
	{
		extract($rs);
	}
}
if(isset($_GET['did']))
{
	$d=mysql_query("delete from tbl_police where police_id=".$_GET['did']);
	
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


<div class="span12" id="police" >
<h4>Police Details</h4>
<div class="span3"></div>
<div class="span6">
<form method="POST">

 		<input type="text" name="tpname"  id="tpname" placeholder="Police Name" value="<?=$police_name?>" style="width:90%"/><br />
		<input type="text" name="tpcnct" maxlength="12" id="tpcnct" placeholder="Contact Number" value="<?=$p_contact?>"/>
       <input type="text" name="tpemail"  id="tpemail" placeholder="Email Id" value="<?=$p_email?>" /><br />
       <input type="text" name="tpaddr" id="tpaddr" placeholder="Address" value="<?=$p_address?>" />
      
       <input type="text" name="tpcity" id="tpcity" placeholder="City" value="<?=$p_city?>" /><br />
       <input type="text" name="tpstate" id="tpstate" placeholder="State" value="<?=$p_state?>" />
       <input type="text" name="tpcountry" id="tpcountry" placeholder="Country" value="<?=$p_country?>"/><br />
       <center>
       <?php
	   if(isset($_GET['aid']))
	   {
		?>
		  <input type="submit" class="btn btn-info" name="btnpedit" value="Update" /> 
           
		<?php
        }
		else
		{
	   ?>
       <input type="submit" class="btn btn-info" name="btnpsave" value="Save" />
      
       <?php
		}
	   ?>
       </center>
      </form>

</div>
<div class="span3"></div>
<table class="table" style="background:#FFFFE6;">
<tr>
<th>Police Name</th>
<th>Contact</th>
<th>Email</th>
<th>Address</th>
<th>City</th>
<th>State</th>
<th>Country</th>
<th></th>
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
                <td>
                <a href="policedetails.php?aid=<?=$police_id?>&id=<?=$land_mark_id?>" style="text-decoration:none">
                <b>&nbsp;&nbsp;&nbsp;<i class="icon icon-edit" title="Edit"></i>
                </b>
                </a>
                    <a href="policedetails.php?did=<?=$police_id?>&id=<?=$land_mark_id?>" style="text-decoration:none">
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