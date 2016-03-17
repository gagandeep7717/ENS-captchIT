var x1=false;
if(window.XMLHttpRequest)
{
	 x1=new XMLHttpRequest();
}
else if(window.ActiveXObject)
{
	x1=new ActiveXObject("Microsoft.XMLHTTP");
}
function getComplaint()
{
	if(x1)
	{  
	    var path="complaintdata.php";
		x1.open("GET",path);
		x1.onreadystatechange=function()
		{
			if(x1.readyState==4 && x1.status==200)
			{
				document.getElementById("complaintgrid").innerHTML=x1.responseText;
			}
		}
		x1.send(null);
	}	
}
function searchcomp()
{
	if(x1)
	{  
		var ctype=document.getElementById('comptype').value;
		
	    var path="searchcompdata.php?ctype="+ctype;
		x1.open("GET",path);
		x1.onreadystatechange=function()
		{
			if(x1.readyState==4 && x1.status==200)
			{
				document.getElementById("complaintgrid").innerHTML=x1.responseText;
			}
		}
		x1.send(null);
	}	
}


function landmark_details(landid)
{
	if(x1)
	{  
		
	    var path="landmarkdata.php?landid="+landid;
		x1.open("GET",path);
		x1.onreadystatechange=function()
		{
			if(x1.readyState==4 && x1.status==200)
			{
				document.getElementById("ldetails"+landid).innerHTML=x1.responseText;
				document.getElementById("viewspan"+landid).style.display="none";
				document.getElementById("hidespan"+landid).style.display="block";
			}
		}
		x1.send(null);
	}	
}
function hidelandmark_details(landid)
{
			document.getElementById("ldetails"+landid).innerHTML="";
		    document.getElementById("viewspan"+landid).style.display="block";
		    document.getElementById("hidespan"+landid).style.display="none";
}
function delete_record(table,key,id,landid)
{
	if(x1)
	{  
		
	    var path="deletedata.php?table="+table+"&pkey="+key+"&id="+id;
		x1.open("GET",path);
		x1.onreadystatechange=function()
		{
			if(x1.readyState==4 && x1.status==200)
			{
				
				if(table == "tbl_landmarkdetails")
				{ 
					landmark_details(landid);
				}
				else
				window.location.reload();
			}
		}
		x1.send(null);
	}	
}
function addlandmark()
{
		
		    document.getElementById("addlandmarkform").style.display="block";
		    document.getElementById("addlandmark").style.display="none";
}
function addldetails(landid)
{
		
		    document.getElementById("addform"+landid).style.display="block";
		    document.getElementById("linkadd"+landid).style.display="none";
}
function hideaddform(landid)
{
		
		    document.getElementById("addform"+landid).style.display="none";
		    document.getElementById("linkadd"+landid).style.display="block";
}
function savelanddetails(landid)
{
	if(x1)
	{  
	
	    var pno = document.getElementById('tpoliceno').value;
	    var fno = document.getElementById('tfireno').value;
	    var mno = document.getElementById('tmedicalno').value;
	    var eno = document.getElementById('telecno').value;
		
		
		var pml = document.getElementById('tpolicemail').value;
		var fml = document.getElementById('tfiremail').value;
		var mml = document.getElementById('tmedicalmail').value;
		var eml = document.getElementById('telecmail').value;
		
	    var path="savelanddata.php?pno="+pno+"&fno="+fno+"&mno="+mno+"&eno="+eno+"&pml="+pml+"&fml="+fml+"&mml="+mml+"&eml="+eml+"&landid="+landid;
		
		
		
		x1.open("GET",path);
		
		x1.onreadystatechange=function()
		{
			if(x1.readyState==4 && x1.status==200)
			{
				
				landmark_details(landid);
			}
		}
		x1.send(null);
	}	
}

function showedit(id)
{
	document.getElementById("editform"+id).style.visibility="visible";
	document.getElementById("lform"+id).style.visibility="collapse";
}
function hideedit(id)
{
	document.getElementById("editform"+id).style.visibility="collapse";
	document.getElementById("lform"+id).style.visibility="visible";
}
function editsave(id,landid)
{
	if(x1)
	{  
	
	    var pno = document.getElementById('tpno').value;
	    var fno = document.getElementById('tfno').value;
	    var mno = document.getElementById('tmno').value;
	    var eno = document.getElementById('teno').value;
		
		
		var pml = document.getElementById('tpm').value;
		var fml = document.getElementById('tfm').value;
		var mml = document.getElementById('tmm').value;
		var eml = document.getElementById('tem').value;
		
	    var path="editlanddata.php?pno="+pno+"&fno="+fno+"&mno="+mno+"&eno="+eno+"&pml="+pml+"&fml="+fml+"&mml="+mml+"&eml="+eml+"&id="+id;
		
		
		
		x1.open("GET",path);
		
		x1.onreadystatechange=function()
		{
			if(x1.readyState==4 && x1.status==200)
			{
				
				landmark_details(landid);
			}
		}
		x1.send(null);
	}	
}


