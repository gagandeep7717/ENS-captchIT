<?php
	
	$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");
		
                $complaintby=$_POST["name"];
		$mobileno=$_POST["mobileno"];
		$landmark=$_POST["landmark"];
                $type=$_POST["type"];
                $location=$_POST["location"];
                $latitude=$_POST["lat"];
                $longitude=$_POST["longi"];
                $imgname=$_POST["imgname"];
                $status="0";
                $today=date("y/m/d");
		
		$sql=mysql_query("Insert into tbl_civil_complaint(complaintby,mobileno,landmark,type,location,latitude,longitude,imgname,status,date) 
						values('$complaintby','$mobileno','$landmark','$type','$location','$latitude','$longitude','$imgname','$status','$today')");
		$result=mysql_query($sql);
		
		while($row=mysql_fetch_assoc($result))
			{
				$output[]=$row;
			}
			print(json_encode($output));
	mysql_close();
?>