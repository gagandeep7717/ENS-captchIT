<?php
$con=mysqli_connect("localhost","captchit","###nsk@@@","captchit_main_database") or die(mysql_error());
$username=$_POST["username"];
$password=$_POST["password"];  
$imei=$_POST["imei"];  


$sql = "SELECT * From tbl_registration WHERE username = '$username' and password = '$password'";
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_assoc($result))
{
 $output[]=$row;     
 print(json_encode($output));  
 $qry=mysqli_query($con,"UPDATE `tbl_registration` SET `imei`=$imei WHERE username = '$username' and password= '$password' "); 
 break;                
}
mysqli_close();
?>