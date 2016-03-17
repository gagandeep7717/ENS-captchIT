<?php
	include 'mail.php';
	$mail = new maillib();

	$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Can not connect");
		mysql_select_db("captchit_main_database") or die("DB not Selected");

                $complaintby=$_POST["name"];
		$mobileno=$_POST["mobileno"];
		$location=$_POST["location"];
		//$landmark=$_POST["landmark"];
		$type=$_POST["type"];

                $latitude=$_POST["lat"];
		$longitude=$_POST["longi"];
		$status="0";
		$date = new Datetime();
                $pwd = $date->getTimestamp();
                $pwd = $pwd.''.rand(999,9999);    

//$landmark = "select Landmark by substring from location";		
		$sql="Insert into tbl_ex_emer(complaintby,mobileno,location,landmark,type,latitude,longitude,status,date,pwd) 
						values('$complaintby','$mobileno','$location','Panchavati','$type','$latitude','$longitude','$status',NOW(),'$pwd')"; 


	        echo $sql;
		$result=mysql_query($sql);

                  if($sql)
		{
			$body = "Complaint Regarding Accident.<br>
At Panchavati.<br>Password = $pwd <br>For more details, Please View following Link. <a href='http://103.12.211.176/~captchit/s.php'>Click Here</a>";
					
	$subject="Regarding Extreme Emergency ";
	
	
	
	echo $body."<br>";
			$qry = mysql_query("select * from tbl_landmark where landmark='Panchavati'");
			while($res = mysql_fetch_array($qry))
			{
				extract($res);
echo "in";

				if($_POST["type"] == "extreme_emergency")
				{
echo "come in";
					$qry_po=mysql_query("select * from tbl_police p where p.land_mark_id=$landmarkid");
					echo "select * from tbl_police p where p.land_mark_id=$landmarkid";
					
					while($r_po = mysql_fetch_array($qry_po))
					{
							extract($r_po);
							$temail = $p_email;
echo"$temail<br />";
							$mail->sendmail($temail,$subject,$body);
					}
					
					
					$qry_hos=mysql_query("select * from tbl_hospital h where h.land_mark_id=$landmarkid ");
					
					while($r_hos=mysql_fetch_array($qry_hos))
					{
						extract($r_hos);
						
						$temail = $h_email;
//echo"$temail";
						$mail->sendmail($temail,$subject,$body);
					}
				}
				
			}
		}  
						
	mysql_close();
?>