<?php
	include 'mail.php';
	$mail = new maillib();
	
	
	$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
	//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Can not connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");
		
		$complaintby=$_POST["name"];
		$mobileno=$_POST["mobileno"];
		$location=$_POST["location"];
		$lat=$_POST["lat"];
		$longi=$_POST["longi"];
		$landmark=$_POST["landmark"];
		$type=$_POST["type"];		
		$imgname=$_POST["imgname"];
		$status="0";
        $today=date("y/m/d");
$date = new Datetime();
$pwd = $date->getTimestamp();
$pwd = $pwd.''.rand(999,9999);
$temail='';
		
		
		//$type='Electric Problem';
		/*$sql="Insert into tbl_complaint(complaintby,mobileno,location,lat,longi,landmark,type,imgname,status,date,pwd) 
						values('AAA','758809090','nasik','23','24','Panchavati','Accident','IMG_20140224_173907.png','0',NOW(),'".$pwd."')" or die(mysql_error());*/
						
						$sql=mysql_query("Insert into tbl_complaint(complaintby,mobileno,location,lat,longi,landmark,type,imgname,status,date,pwd) 
						values('$complaintby','$mobileno','$location','$lat','$longi','$landmark','$type','$imgname','$status','$today','$pwd')");
echo $sql;
		//$result=mysql_query($sql);

		if($sql)
		{
			$body = "Complaint Regarding $type.<br>
At $location.<br>Password = $pwd <br>For more details, Please View following Link. <a href='http://103.12.211.176/~captchit/secure.php'>Click Here</a>";
					
	$subject="Regarding $type";
	
	$smstext = "Complaint regarding $type , At $location";
	
			$e="select * from tbl_landmark where landmark='$landmark'";
			
			
			
			
			$qry = mysql_query($e);
			//echo $e;
			while($res = mysql_fetch_array($qry))
			{
				extract($res);
				if($type == "Accident")
				{
			
					$qry_po=mysql_query("select * from tbl_police p where p.land_mark_id=$landmarkid ");
					//echo $r;
					
					while($r_po=mysql_fetch_array($qry_po))
					{
							extract($r_po);
							$temail = $p_email;
							$tmobile = $p_contact;
//echo"$temail<br />";
							$mail->sendmail($temail,$subject,$body);
							$mail->sendsms($tmobile,$smstext);
					}
					
					
					$qry_hos=mysql_query("select * from tbl_hospital h where h.land_mark_id=$landmarkid");
					
					while($r_hos=mysql_fetch_array($qry_hos))
					{
						extract($r_hos);
						
						$temail = $h_email;
						$tmobile = $h_contact;
//echo"$temail";
						$mail->sendmail($temail,$subject,$body);
						$mail->sendsms($tmobile,$smstext);
					}
				}
				
				else
				if($type == "Fire")
				{
					
					
					$qa=mysql_query("select * from tbl_police p where p.land_mark_id=$landmarkid ");
					
					while($ra=mysql_fetch_array($qa))
					{
							extract($ra);
							$temail = $p_email;
							$tmobile = $p_contact;
//echo"$temail";
							$mail->sendmail($temail,$subject,$body);
							$mail->sendsms($tmobile,$smstext);
					}
					
					
					
					
					
					$qp=mysql_query("select * from tbl_hospital h where h.land_mark_id=$landmarkid ");
					
					while($rp=mysql_fetch_array($qp))
					{
						extract($rp);
						
						$temail = $h_email;
						$tmobile = $h_contact;
//echo"$temail";
						$mail->sendmail($temail,$subject,$body);
						$mail->sendsms($tmobile,$smstext);
					}
					
					
					
					$qf=mysql_query("select * from tbl_fire f where f.land_mark_id=$landmarkid ");
					
					while($rf=mysql_fetch_array($qf))
					{
						extract($rf);
						
						$temail = $f_email;
						$tmobile = $f_contact;
//echo"$temail";
						$mail->sendmail($temail,$subject,$body);
						$mail->sendsms($tmobile,$smstext);
					}
				}
				
				
				else
				if($type == "Medical")
				{

					$qp=mysql_query("select * from tbl_hospital h where h.land_mark_id=$landmarkid ");
					
					while($rp=mysql_fetch_array($qp))
					{
						extract($rp);
						
						$temail = $h_email;
						$tmobile = $h_contact;
//echo"$temail";
						$mail->sendmail($temail,$subject,$body);
						$mail->sendsms($tmobile,$smstext);
					}
				}
				
				
				
				else
				if($type == "Crime Activity")
				{

					$qa=mysql_query("select * from tbl_police p where p.land_mark_id=$landmarkid ");
					
					while($ra=mysql_fetch_array($qa))
					{
							extract($ra);
							$temail = $p_email;
							$tmobile = $p_contact;
//echo"$temail";
							$mail->sendmail($temail,$subject,$body);
							$mail->sendsms($tmobile,$smstext);
					}
				}
				else
				if($type == "Electric Problem")
				{
					
					$qe=mysql_query("select * from tbl_electricity e where e.land_mark_id=$landmarkid ");
					
					while($re=mysql_fetch_array($qe))
					{
							extract($re);
							$temail = $e_email;
							$tmobile = $e_contact;
//echo"$temail";
//echo "$tmobile";
//echo "$smstext";
							$mail->sendmail($temail,$subject,$body);
							$mail->sendsms($tmobile,$smstext);
					}
				}
			}
		}
						
						
						
		/*$result=mysql_query($sql);
		
		while($row=mysql_fetch_assoc($result))
			{
				$output[]=$row;
			}
			print(json_encode($output));*/
	mysql_close();
?>