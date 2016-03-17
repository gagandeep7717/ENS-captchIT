<script src="ajax.js"></script>
<?php

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");
mysql_select_db("captchit_main_database") or die("DB not Selected");

include '../includes/front-res.php';


if(isset($_GET['table']) && isset($_GET['pkey']) && isset($_GET['id']))
{
	extract($_GET);

	 $q1 = mysql_query("delete from ".$_GET['table']." where ".$_GET['pkey']."=".$_GET['id']);
	 
	 
	 if($_GET['table'] == 'tbl_landmark')
	 {
		 $q2 = mysql_query("delete from tbl_landmarkdetails where landmarkid=".$_GET['id']); 
	 }
	 
	

}

?>
