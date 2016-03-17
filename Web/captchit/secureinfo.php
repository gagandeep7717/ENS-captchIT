<?php
$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("localhost","root","") or die("Can not connect");
		mysql_select_db("captchit_main_database") or die("DB not Selected");




if(isset($_POST['btnsubmit']))
{
	extract($_POST);
	?>
    
    <center>
    <h1>Complaint Details</h1><hr />
    <br /><br />
    <?php
	 $q=mysql_query("select * from tbl_complaint where pwd = $tpwd");
	 if($r = mysql_fetch_array($q))
	 {
		extract($r);
		
		if($status == 1)
		 {
			 ?>
             <h3 style="background:#D9ECFF;color:#06F;">This Complaint is Already Viewed.</h3>
             <?php
		 }
		 else if($status == 2)
		 {
			 ?>
             <h3 style="background:##f00;color:#fff;">This Complaint is Already Served.</h3>
             <?php
		 }
		 
	?>
    <br><br>
    
    <table width="50%" cellpadding="10" border="1" style="background:#000;color:#fff !important;font-size:16px;">
 
        <tr width="50%">
        <td>
        <b>Mobile No</b> : 
        </td>
		<td>
		<?= $mobileno?>
        </td>
        </tr>
        <tr>
        <td>
        <b>Landmark</b> : 
		</td>
		<td><?= $landmark?>
        </td>
        </tr>
        <tr>
        <td>
        <b>Location</b> : 
		</td>
		<td>
		<?= $location?>
        </td>
        </tr>
        <tr>
        <td>
        <b>Type</b> : 
		</td>
        <td>
		<?= $type?>
        </td>
        </tr>
     
        <tr>
        <td>
        <b>Image</b> :
        </td>
        <td>
        <img src="http://103.12.211.176/~captchit/uploads/Emergency/<?= $imgname?>" alt="<?= $imgname?>">
        </td>
        </tr>
        <tr>
        <td colspan="2" align="center">
        <a href="map.php?lat=<?=$lat?>&lon=<?= $longi?>" style="color:#09F;font-style:bold;"><b>View Map</b></a>
        </td>
        </tr>
        
    </table>
	
	<br><br><br>
	<form method="post" action="acceptrequest.php">

	<h4>Click here if you are willing to serve this request.</h4>

	<input type="submit" name="btnaccept" value="Accept" style="width:70px; height:32px; background:#0080FF;color:#fff;"/>

	</form>
	
    <?php
	 }//if
	 $qry1 = mysql_query("update tbl_complaint set status = 1 where pwd = $tpwd");
	
	?>
    <?php
	
}
?>

</center>