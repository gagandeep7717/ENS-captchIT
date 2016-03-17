<?php
@session_start();
@ob_start();

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");
mysql_select_db("captchit_main_database") or die("DB not Selected");

if(isset($_GET['pno']))
{
	
	extract($_GET);
	
	$q1 = mysql_query("INSERT INTO `captchit_main_database`.`tbl_landmarkdetails` (`landmarkid`, `policeno`, `policemail`, `fireno`, `firemail`, `medicalno`, `medicalmail`, `electricno`, `electricmail`) VALUES ('$landid', '$pno', '$pml', '$fno', '$fml', '$mno', '$mml', '$eno', '$eml')");
	
}

?>