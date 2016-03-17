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
<?php include '../includes/front-res.php';?>

</head>
<body>

<?php include '../includes/front-header.php';?>
<?php
if(isset($_GET['compid']))
{
	$q = mysql_query("update tbl_civil_complaint set status='Completed' where id=".$_GET['compid']);
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

<div class="span12">

<h3>Civil Complaints</h3>
<table class="table">
<tr>
<th>Image</th>
<th>Complaint By</th>
<th>Mobile NO.</th>
<th>Landmark</th>
<th>Type</th>
<th>Location</th>
<th>Date</th>
<th>Map</th>
<th>Status</th>
<?php
if(isset($_SESSION['superadmin']))
{
	?>
    
    <th>Change Status</th>
    <?php
}
?>
</tr>

<?php
 $class="";
 $qry1 = mysql_query("select * from tbl_civil_complaint order by id desc");
 while($res1=mysql_fetch_array($qry1))
 {
	 extract($res1);
	 if($status == "In Progress")
	 {
	  $class="yellow";
	  $status = "<span class='label label-inverse'>In Progress</span>";
	 }
	 else
	 {
	   $class="green";
	   $status = "<span class='label label-success'>Completed</span>";
	 }
	 ?>
     <tr class="<?= $class?>">
     <td><img src="../uploads/CIVIL/<?= $imgname?>" style="height:100px;width:200px"></td>
     <td><?= $complaintby?></td>
     <td><?= $mobileno?></td>
     <td><?= $landmark?></td>
     <td><?= $type?></td>
     <td><?= $location?></td>
     <td><?= $date?></td>
     <td><a href="../map.php?lat=<?=$latitude?>&lon=<?= $longitude?>">View Map</a></td>
     <td><?= $status?></td>
     <?php
	  if(isset($_SESSION['superadmin']))
	  {
		 
           if($status=="<span class='label label-inverse'>In Progress</span>")
		  {
		  ?>
		  <td><a href="civilcomp.php?compid=<?= $id?>"><img src="../images/tick.png" style="width:30px;height:30px"></a></td>
          
		  <?php
		  }
		  else
		    echo"<td></td>";
		 }
	  else
	  {
		  echo"<td></td>";
		
	  }
	  ?>
     </tr>
     <?php
 }
?>




</table>
<br><bR><br><br>

          


</div>
</div>
</div>



</body>

</html>