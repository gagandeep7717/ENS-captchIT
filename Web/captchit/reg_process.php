<?php
// Create connection
$con=mysqli_connect("localhost","captchit","###nsk@@@","captchit_main_database");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Can not connect");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$name = $_POST["name"];
$address = $_POST["address"];
$mobile = $_POST["mobile"];
$username= $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$today = date("Y/m/d");


echo "First Name : ".$name;
echo "<br>";
echo "Address : " . $address;
echo "<br>";
echo "Mobile : " . $mobile;
echo "<br>";
echo "User Name : " . $username;
echo "<br>";
echo "Email Id:" . $email;
echo "<br>";




$query = "INSERT INTO `tbl_reg`(`name`,`address`, `mobile`, `email`,`username`, `password`, `dateofreg`) VALUES ('".$name."','".$address."','".$mobile."','".$email."','".$username."','".$password."','".$today."')";

mysqli_query($con,$query);

mysqli_close($con);
?>