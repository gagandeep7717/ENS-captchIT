 <?php
						  


   $con=mysqli_connect("localhost","captchit","###nsk@@@","captchit_main_database") or die(mysql_error());

          
                 $imei=$_POST["imei"];
                
		  $sql="SELECT * From tbl_registration WHERE imei= '$imei'";
                		
		$result=mysqli_query($con,$sql);
                   
		while($row=mysqli_fetch_assoc($result))
			{
				$output[]=$row;     
                                print(json_encode($output));  
                                               
			}
			
?>