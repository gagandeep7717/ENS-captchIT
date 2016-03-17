<?php
@session_start();
@ob_start();


$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");
mysql_select_db("captchit_main_database") or die("DB not Selected");

include '../includes/front-res.php';


if(isset($_GET['ctype']))
{
	extract($_GET);
	if($ctype != 'All')
	 $q1 = "select * from tbl_complaint where type='".$_GET['ctype']."' order by id desc";
	 else
	 $q1 = "select * from tbl_complaint order by id desc";
	 

}

?>
<h3>Emergency Complaints</h3>
<table class="table">
<tr>
<th>Image</th>
<th>Complaint By</th>
<th>Mobile NO.</th>
<th>Location</th>
<th>Landmark</th>
<th>Type</th>
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
 $qry1 = mysql_query($q1);
 while($res1=mysql_fetch_array($qry1))
 {
	 extract($res1);
	 if($status == 0)
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
     <td><img src="../uploads/Emergency/<?= $imgname?>" style="height:100px;width:200px"></td>
     <td><?= $complaintby?></td>
     <td><?= $mobileno?></td>
     <td><?= $location?></td>
     <td><?= $landmark?></td>
     <td><?= $type?></td>
     <td><?= $date?></td>
     <td><a href="../map.php?lat=<?=$lat?>&lon=<?= $longi?>">View Map</a></td>
     <td><?= $status?></td>
     <?php
	  if(isset($_SESSION['superadmin']))
	  {
		 
           if($status=="<span class='label label-inverse'>In Progress</span>")
		  {
			?> 
    
		  <td><a href="complaints.php?compid=<?= $id?>"><img src="../images/tick.png" style="width:30px;height:30px"></a></td>
          
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

          
