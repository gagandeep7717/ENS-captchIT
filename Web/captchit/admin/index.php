<?php
@session_start();
@ob_start();

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");

		mysql_select_db("captchit_main_database") or die("DB not Selected");
?>
<!DOCTYPE html>
<html>
<head>
<title>Captchit | Login</title>
<meta charset="UTF-8">
<?php include '../includes/front-res.php';?>

</head>
<body>

<div class="row-fluid header">

<img src="../images/logo.png" style="height:100px;margin-top:10px;margin-left:15px;">

</div>
<div class="row-fluid">
<div class="lace"></div>
</div>


<div class="row-fluid">
<div class="container">

<div class="span12">


<?php
				
					if(isset($_POST['btnlogin']))
					{
						extract($_POST);
						$qry = "select * from tbl_admin where auname='".$tuname."' and apass='".$tpassword."'";
						$q = mysql_query($qry);
						if(mysql_num_rows($q)==1)
						{
							$r = mysql_fetch_array($q);
							extract($r);
							if($auname==$tuname && $apass==$tpassword)
							{
								if($auname == "superadmin")
								  $_SESSION['superadmin']=$auname;
															
								
								$_SESSION['admin']=$auname;							
								header("location:adminhome.php");
							}		
							
						}
						else
						{
							echo "<br /><center>
											<div class='alert button button-pill button-flat' style='max-width:500px;'>
											
												Invalid login details..!!!
											</div>
											</center><br />";
						}		
					}	
				?>
<div class="span3"></div> 
 
<div class="span6">
<br><br>
<h3> Administrator Login </h3><hr />

<form class="form-horizontal" id="formID" method="post">
  <div class="control-group">
    <label class="control-label" for="tuname">Username</label>
    <div class="controls">
      <input type="text" id="tuname" name="tuname" class="validate[required]" placeholder="Username">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="tpassword">Password</label>
    <div class="controls">
      <input type="password" id="tpassword" name="tpassword"  class="validate[required]" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
           <button type="submit" name="btnlogin" id="btnlogin" class="btn btn-info">Sign in</button>
    </div>
  </div>
</form>           
     
 <hr />
 </div>
 
 <div class="span3"></div>           


</div>
</div>
</div>



</body>

</html>