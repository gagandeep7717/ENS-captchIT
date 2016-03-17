<html>
<head>
<title>
Registration Form
</title>
</head>
<style>
.col1
{
 display:inline-block;
 width:150px;
}
.col2
{
 display:inline-block;

}
.row
{
 margin: 0 auto;
 width: 70%;
 background-color:beige;
 padding:8px 8px;
}
.button
{
 height:30px;
 width:100px;
 font-weight:bold;
}
</style>
<body>

  <div style="margin:0 auto;width:100%;background-color:lightblue;">
   <h1 style="text-align:center"> Registration Form </h1>
   <center>Please Enter Details For Verification </center>
   <div style="margin: 0 auto;width:50%;background-color:lightcyan;">
    <form name="regform" action="reg_process.php" onsubmit="return validateForm()" method="post">
     <div class="row">
	   <div class="col1"> Name : </div> 
	   <div class="col2"> <input type="text" name="name" style = "width :300px"> </div>
     </div>
    
    
     <div class="row">
	   <div class="col1"> Address : </div> 
	   <div class="col2"> <input type="text" name="address" style = "width :300px"> </div>
     </div>
     
     <div class="row">
	   <div class="col1"> Mobile  </div> 
	   <div class="col2"> <input type="text" name="mobile" style = "width :300px"> </div>
     </div>
     
     <div class="row">
	   <div class="col1"> Email Id : </div> 
	   <div class="col2"> <input type="text" name="email" style = "width :300px"> </div>
     </div>
     <div class="row">
	   <div class="col1"> User Name : </div> 
	   <div class="col2"> <input type="text" name="username" style = "width :300px"> </div>
     </div>
	
     <div class="row">
	   <div class="col1"> Password : </div> 
	   <div class="col2"> <input type="password" name="password" style = "width :300px"> </div>
     </div>
     <div class="row">
	   <div class="col1"> Confirm Password :</div> 
	   <div class="col2"> <input type="password" name="cpassword" style = "width :300px"> </div>
     </div>
     <div class="row" style="text-align:center">
       <div style="display:inline-block;"><input class="button" type="submit" value="Submit"></input></div>
       <div style="display:inline-block;"><input class="button" type="reset" value="Reset"></input></div>
     </div>
    </form>
   </div> 
  <div>
</body>
</html>

<script>
 function validateForm()
 {
  var x=document.forms["regform"]["name"].value;
  if (x==null || x=="")
    {
     alert("First name must be filled out");
     return false;
    }

 var x=document.forms["regform"]["address"].value;
  if (x==null || x=="")
    {
     alert("Address must be filled out");
     return false;
    }
 var x=document.forms["regform"]["mobile"].value;
  if (x==null || x=="")
    {
     alert("Mobile must be filled out");
     return false;
    }
  var x=document.forms["regform"]["username"].value;
  if (x==null || x=="")
    {
     alert("User name must be filled out");
     return false;
    }
 var x=document.forms["regform"]["email"].value;
  if (x==null || x=="")
    {
     alert("Email id must be filled out");
     return false;
    }
  else
    {
     filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
     console.log(filter.test(x));
     if (!filter.test(x)) 
     {      
      alert("Invalid Email Address"); 
      return false;
     }
    }
 
 var x=document.forms["regform"]["password"].value;
  if (x==null || x=="")
    {
     alert("Password must be filled out");
     return false;
    }
 var x=document.forms["regform"]["cpassword"].value;
  if (x==null || x=="")
    {
     alert("Confirm Password must be filled out");
     return false;
    }
 if(!(document.forms["regform"]["password"].value===document.forms["regform"]["cpassword"].value))
  {
    alert("Password must match");
    return false;
  }
}
</script>