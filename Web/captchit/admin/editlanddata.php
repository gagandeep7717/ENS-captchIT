<?php
@session_start();
@ob_start();

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");
mysql_select_db("captchit_main_database") or die("DB not Selected");

if(isset($_GET['id']))
{
	
	extract($_GET);
	
	$q1 = mysql_query("update tbl_landmarkdetails set policeno='$pno', policemail='$pml', fireno='$fno', firemail='$fml', medicalno='$mno', medicalmail='$mml', electricno='$eno', electricmail='$eml' where id=$id");
	
}

?>