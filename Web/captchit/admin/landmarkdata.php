<?php

$db_connect =mysql_connect("localhost","captchit","###nsk@@@") or die("Can not connect");
//$db_connect =mysql_connect("database-server","astiwz","password123") or die("Cannot connect");
mysql_select_db("captchit_main_database") or die("DB not Selected");

include '../includes/front-res.php';
?>
<style>
input{
	height:20px !important;
}
button{
	height:32px !important;
}

.edit{
	
	height:17px !important;
	width:90px !important;
	border-radius:0;
}
</style>
<?php


if(isset($_GET['landid']))
{
	extract($_GET);

	 $q1 = "select * from tbl_landmarkdetails where landmarkid=".$_GET['landid'];
	 
	 $cnt = mysql_num_rows(mysql_query($q1));
	 
	  
	 ?>
    <div class="row-fluid">
     <div class="span6 offset5" id="addform<?=$_GET['landid']?>" style="display:none;background:#FFF5EC;padding:20px;border-radius:3px;border:1px solid #FF9428;">
      
      <i class="pull-right icon icon-remove" style="cursor:pointer;" onclick="hideaddform('<?= $_GET['landid']?>')"></i>
      
      <span class="text-warning"><b>Add Landmark Details</b></span><hr />
      
      <form method="post">
       <input type="text" name="tpoliceno" maxlength="12" id="tpoliceno" placeholder="Police Number" />
       <input type="text" name="tpolicemail" id="tpolicemail" placeholder="Police Email" /><br />
       
       <input type="text" name="tfireno" maxlength="12" id="tfireno" placeholder="Fire Number" />
       <input type="text" name="tfiremail" id="tfiremail" placeholder="Fire Email" /><br />
      
       <input type="text" name="tmedicalno" maxlength="12" id="tmedicalno" placeholder="Medical Number" />
       <input type="text" name="tmedicalmail" id="tmedicalmail" placeholder="Medical Email" /><br />
      
       <input type="text" name="telecno" maxlength="12"  id="telecno" placeholder="Electric Problem Number" />
       <input type="text" name="telecmail" id="telecmail" placeholder="Electric Problem Email" /><br />
       
       
       
       <button type="button" class="btn btn-info" name="btnsave" onclick="savelanddetails('<?= $_GET['landid']?>')" />Save</button>
       
      </form>
     </div>
     <?php
	
	
	
	 
		 ?>
         <!--<b id="linkadd<?=$_GET['landid']?>" class="pull-right" onclick="addldetails('<?=$_GET['landid']?>')" style="cursor:pointer;">-->
         <a href="add_record.php?id=<?=$_GET['landid']?>" style="text-decoration:none"><b class="pull-right" style="curser:pointer">
         <i class="icon icon-plus"></i>
         <span class="text-warning">Add Record</span>
         </b></a>
         <?php
     
	
}

?>
</div>
<h3>Details</h3>
<table class="table" style="background:#FFFFE6;">

<tr>
<th>Police No.</th>
<th>Police Email</th>
<th>Fire No.</th>
<th>Fire Email</th>
<th>Medical No.</th>
<th>Medical Email</th>
<th>Electric No.</th>
<th>Electric Email</th>
<th>Action</th>
</tr>

<?php

 $qry1 = mysql_query($q1);
 while($res1=mysql_fetch_array($qry1))
 {
	 extract($res1);
	 
	 ?>
     <tr id="lform<?= $id?>">
     <td><?= $policeno?></td>
     <td><?= $policemail?></td>
     <td><?= $fireno?></td>
     <td><?= $firemail?></td>
     <td><?= $medicalno?></td>
     <td><?= $medicalmail?></td>
     <td><?= $electricno?></td>
     <td><?= $electricmail?></td>
     <td>
     
     <span class="text-error" style="cursor:pointer;" onclick="showedit('<?= $id?>')">
     <b>&nbsp;&nbsp;&nbsp;<i class="icon icon-edit" title="Edit"></i></b></span>
     
     <span class="text-error" style="cursor:pointer;" onClick="delete_record('tbl_landmarkdetails','id','<?= $id?>','<?= $landmarkid?>')">
     <b>&nbsp;&nbsp;&nbsp;<i class="icon icon-trash" title="Delete"></i></b></span>
     
          
     </td>
     </tr>
    
     
     <tr id="editform<?= $id?>" style="visibility:collapse;">
     <td>
	 <input type="text" id="tpno" class="edit" value="<?= $policeno?>" />
     </td>
     <td>
	 <input type="text" id="tpm" class="edit" value="<?= $policemail?>" />
     </td>
     <td>
	 <input type="text" id="tfno" class="edit" value="<?= $fireno?>" />
     </td>
     <td>
	 <input type="text" id="tfm" class="edit" value="<?= $firemail?>" />
     </td>
     <td>
	 <input type="text" id="tmno" class="edit" value="<?= $medicalno?>" />
     </td>
     <td>
	 <input type="text" id="tmm" class="edit" value="<?= $medicalmail?>" />
     </td>
     <td>
	 <input type="text" id="teno" class="edit" value="<?= $electricno?>" />
     </td>
     <td>
	 <input type="text" id="tem" class="edit" value="<?= $electricmail?>" />
     </td>
      <td>
      &nbsp;&nbsp;&nbsp;
      <i class="icon icon-ok" title="Update" onclick="editsave('<?= $id?>','<?= $landmarkid?>')" style="cursor:pointer;"></i>
      &nbsp;&nbsp;&nbsp;
      <i class="icon icon-remove" title="Cancel" onclick="hideedit('<?= $id?>')" style="cursor:pointer;"></i>
     
     </td>
      
     
    </tr>
    
     <?php
 }
?>




</table>
<br><br><br><br>

          
