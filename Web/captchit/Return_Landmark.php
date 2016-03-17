<?php
	
	$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");
		
               
                $imei=$_POST["imei"];
                
		$sql="Select landmark From tbl_landmark";
		$result=mysql_query($sql);
		
		while($row=mysql_fetch_assoc($result))
			{
				$output[]=$row;
			}
			print(json_encode($output));
	mysql_close();
?>