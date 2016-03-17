<?php
if(!isset($_SESSION['admin']))
{
	header('location: index.php');
}
?>
<?php

	$pages = array('adminhome.php'=>'Home__home',
	'complaints.php'=>'Emergency Complaints__emergency complaints',
	'civilcomp.php'=>'Civil Complaints__civil complaints',
	'landmark.php'=>'Landmarks__landmarks'
	
	);
	
	$pageurl = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageurl .= "s";}
		$pageurl .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageurl .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageurl .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
	
	
?>

<div class="row-fluid header">

<img src="../images/logo.png" style="height:100px;margin-top:10px;margin-left:15px;">

</div>


            <div class="navbar" style="margin-bottom:-2px;">
              <div class="navbar-inner">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <a class="brand" href="#">Captchit</a>
                  <div class="nav-collapse collapse navbar-responsive-collapse">
                    <ul class="nav">
                     
                     
                     
                     <?php
					foreach($pages as $k=>$v)
					{
								
						$pos = stripos($pageurl,$k);
						$name=substr($v, 0, strpos($v,'__')); 
						$title=substr($v, strpos($v,'__')+2); 
						
						if($pos)
						{
						?>
                      <li class="active"><a href="<?=$k?>" title="<?=$title?>"><?= $name?></a></li>
                      
                       <?php
						}
						else
						{
						?>
                        
                      <li><a href="<?=$k?>" title="<?=$title?>"><?= $name?></a></li>
                      <?php
						}
					  }
					  ?>
                    
                     
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$_SESSION['admin']?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li><a href="logout.php">Logout</a></li>
                         
                          <li class="divider"></li>
                         
                          <li class="nav-header">Captchit</li>
                          
                        </ul>
                      </li>
                      
                      
                    </ul>
                    
                    
                    
                 
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div><!-- /navbar -->
          
<div class="row-fluid">
<div class="lace"></div>
</div>

