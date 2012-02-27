var cp = new cpaint();
cp.set_transfer_mode('get');
cp.set_response_type('xml');
cp.set_debug(0);

        function imgstatus(status) {

                formblock= document.getElementById("images");
                forminputs = formblock.getElementsByTagName('input');
         var chkid="";
        for (i = 0; i < forminputs.length; i++)
        {
                // regex here to check name attribute
                var regex = new RegExp(name, "i");
                if (regex.test(forminputs[i].getAttribute('chk')))
                {
                        if (forminputs[i].checked )
                        {
                                chkid=chkid+"|"+forminputs[i].value;
                        }
                }
        }
               var fileToUse = 'functions.php';
               cp.call(fileToUse,'imgstatus',get_imgstatus,chkid,status);
        }
		
		        function get_imgstatus(result)
        {
            var msg=result.getElementsByTagName('response').item(0).firstChild.data;
            var fid=result.getElementsByTagName('fid').item(0).firstChild.data;
            var status=result.getElementsByTagName('status').item(0).firstChild.data;
            var amtArray = fid.split("|");
            for(i=0;i<amtArray.length;i++)
            {
                if(amtArray[i] && amtArray[i]!="on")

                document.getElementById("s_"+amtArray[i]).innerHTML=status;

            }
            document.getElementById("error").style.display="block";
            document.getElementById("sucmsgid").innerHTML=msg;

        }
		
		
		
        function u_deleteimage() {
        if(!confirm('Are you sure you want to delete the selected photos?'))
        return false;
                formblock= document.getElementById("images");                
                forminputs = formblock.getElementsByTagName('input');
         var chkid="";
	    var authid=document.getElementById("authid").value;
        for (i = 0; i < forminputs.length; i++) 
        {
                // regex here to check name attribute
                var regex = new RegExp(name, "i");
                if (regex.test(forminputs[i].getAttribute('chk'))) 
                {
                       
                        if (forminputs[i].checked ) 
                        {
                                chkid=chkid+"|"+forminputs[i].value;
                                
                        } 
                }
        }
        
               var fileToUse = 'functions.php';               
               cp.call(fileToUse,'u_deleteimage',output,authid,chkid);               
        }
		
		        function deleteimage() {
        if(!confirm('Are you sure you want to delete the selected photos?'))
        return false;
                formblock= document.getElementById("images");                
                forminputs = formblock.getElementsByTagName('input');
         var chkid="";
        for (i = 0; i < forminputs.length; i++) 
        {
                // regex here to check name attribute
                var regex = new RegExp(name, "i");
                if (regex.test(forminputs[i].getAttribute('chk'))) 
                {
                       
                        if (forminputs[i].checked ) 
                        {
                                chkid=chkid+"|"+forminputs[i].value;
                                
                        } 
                }
        }
        
               var fileToUse = 'functions.php';               
               cp.call(fileToUse,'deleteimage',output,chkid);               
        }
		
		function u_delete1image() {
		if(!confirm('Are you sure you want to delete this photo?'))
        return false;
   var d_filename=document.getElementById("d_filename").value;

   
 var fileToUse = 'functions.php';
 cp.call(fileToUse,'delete1image',get_delete1image,d_filename);
 return false;
        }

		function reportimage() {
		if(!confirm('Are you sure you want to report this photo as inappropriate?'))
        return false;
   var r_reporterid=document.getElementById("reporterid").value;
   var r_uploaderid=document.getElementById("uploaderid").value;
   var r_timestamp=document.getElementById("timestamp").value;
   var r_imagename=document.getElementById("imagename").value;
   var r_ip=document.getElementById("ip").value;  

   
 var fileToUse = 'functions.php';
 cp.call(fileToUse,'reportimage',get_reportimage,r_reporterid,r_uploaderid,r_timestamp,r_imagename,r_ip);
 return false;
        }
		
		
	function get_reportimage(result)
    {
        var msg=result.getElementsByTagName('msg').item(0).firstChild.data;
        var id=result.getElementsByTagName('id').item(0).firstChild.data;
        if(id==1)
        {
        document.getElementById("error").style.display="block";
        document.getElementById("sucmsgid").innerHTML=msg;
        }
        else
        {
         document.getElementById(id).select();
        document.getElementById(id).focus();
        document.getElementById("error").style.display="block";
        document.getElementById("msgid").innerHTML=msg;
        }       
    }
	
	
		function s_delete1image() {
		if(!confirm('Are you sure you want to delete this photo?'))
        return false;
   var d_filename=document.getElementById("d_filename").value;
 var fileToUse = 'functions.php';
 cp.call(fileToUse,'s_delete1image',get_delete1image,d_filename);
 return false;
        }
		
			function get_delete1image(result)
    {
        var msg=result.getElementsByTagName('msg').item(0).firstChild.data;
        var id=result.getElementsByTagName('id').item(0).firstChild.data;
        if(id==1)
        {
		document.getElementById("photo").style.display="none";
        document.getElementById("error").style.display="block";
        document.getElementById("sucmsgid").innerHTML=msg;
        }
        else
        {
         document.getElementById(id).select();
        document.getElementById(id).focus();
        document.getElementById("error").style.display="block";
        document.getElementById("msgid").innerHTML=msg;
        }       
    }	
	
function emailCheck (emailStr) {
var emailPat=/^(.+)@(.+)$/;
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
var validChars="\[^\\s" + specialChars + "\]"    ;
var quotedUser="(\"[^\"]*\")"                     ;
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
var atom=validChars + '+'
var word="(" + atom + "|" + quotedUser + ")"
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
var matchArray=emailStr.match(emailPat)
if(emailStr=="")
{ return true}
if (matchArray==null) {
         alert("Email address seems incorrect (check @ and .'s)")
        return false;
}

return true;
}



function validate()
{
 
   var uname=document.getElementById("uname").value;
   var fname=document.getElementById("fname").value;
   var lname=document.getElementById("lname").value;
   var pass=document.getElementById("pass").value;
   var cpass=document.getElementById("cpass").value;
   var email = document.getElementById("email").value;
   if(uname=="")
   {
   var msg="User Name cannot be left empty.";
   alert(msg);
   document.getElementById("uname").select();
  document.getElementById("uname").focus();
   return false;
   }
   if(fname=="")
   {
        msg="First Name cannot be left empty.";
        alert(msg);
        document.getElementById("fname").select();
  document.getElementById("fname").focus();
   return false;
        }

if(lname=="")
{
msg="Last Name cannot be left empty.";
alert(msg);
document.getElementById("lname").select();
  document.getElementById("lname").focus();
   return false;
}
if(email=="")
{
msg="Email Address cannot be left empty.";
alert(msg);
document.getElementById("email").select();
  document.getElementById("email").focus();
   return false;
}
if (!emailCheck(email))
  {
document.getElementById("email").select();
  document.getElementById("email").focus();
   return false;
 }

if(pass=="")
{
msg="Password cannot be left empty.";
alert(msg);
document.getElementById("pass").select();
  document.getElementById("pass").focus();
   return false;
}

if(cpass=="")
{
msg="Confirm password cannot be left empty.";
alert(msg);
document.getElementById("cpass").select();
  document.getElementById("cpass").focus();
   return false;
}
if(pass!=cpass)
{
msg="Password and Confirm password mismatch.";
alert(msg);
document.getElementById("pass").select();
document.getElementById("pass").focus();
return false;
}

passx=pass.length;

    if(passx<6)
    {
    alert("Password is too short! Password should be 6 characters minimum.");
document.getElementById("pass").select();
document.getElementById("pass").focus();
    return false;
    }
	
 var fileToUse = 'functions.php';
 cp.call(fileToUse,'usersignup',get_usersignup,uname,fname,lname,email,pass);
return false;
}
function get_usersignup(result)
{
        var msg=result.getElementsByTagName('msg').item(0).firstChild.data;
        var id=result.getElementsByTagName('id').item(0).firstChild.data;
        if(id==1)
        {
        document.getElementById("error").style.display="block";
        document.getElementById("sucmsgid").innerHTML=msg;
        }
        else
        {
         document.getElementById(id).select();
        document.getElementById(id).focus();
        document.getElementById("error").style.display="block";
        document.getElementById("msgid").innerHTML=msg;
        }
        //alert(msg);
}



function forgetpass()
{
 
   var email=document.getElementById("email").value;
   
  
if(email=="")
{
msg="Email Address cannot be left empty.";
alert(msg);
document.getElementById("email").select();
  document.getElementById("email").focus();
   return false;
}
if (!emailCheck(email))
  {
document.getElementById("email").select();
  document.getElementById("email").focus();
   return false;
 }


 var fileToUse = 'functions.php';
 cp.call(fileToUse,'forgetpass',get_forgetpass,email);
return false;
}
function get_forgetpass(result)
{
        var msg=result.getElementsByTagName('msg').item(0).firstChild.data;
        var id=result.getElementsByTagName('id').item(0).firstChild.data;
        if(id==1)
        {
        document.getElementById("error").style.display="block";
        document.getElementById("sucmsgid").innerHTML=msg;
        }
        else
        {
         document.getElementById(id).select();
        document.getElementById(id).focus();
        document.getElementById("error").style.display="block";
        document.getElementById("msgid").innerHTML=msg;
        }
        //alert(msg);
}

	function chk_profileupdate()
{
   var uname=document.getElementById("uname").value;
   var fname=document.getElementById("fname").value;
   var lname=document.getElementById("lname").value;
   var email = document.getElementById("email").value;
   var oldpass=document.getElementById("oldpass").value;
   var pass1=document.getElementById("pass1").value;
   var pass2=document.getElementById("pass2").value;
   var userid=document.getElementById("userid").value;

   if(uname=="")
   {
   var msg="User Name cannot be left empty.";
   alert(msg);
   document.getElementById("uname").select();
  document.getElementById("uname").focus();
   return false;
   }
   if(fname=="")
   {
        msg="First Name cannot be left empty.";
        alert(msg);
        document.getElementById("fname").select();
  document.getElementById("fname").focus();
   return false;
        }

if(lname=="")
{
msg="Last Name cannot be left empty.";
alert(msg);
document.getElementById("lname").select();
  document.getElementById("lname").focus();
   return false;
}
if(email=="")
{
msg="Email Address cannot be left empty.";
alert(msg);
document.getElementById("email").select();
  document.getElementById("email").focus();
   return false;
}
if (!emailCheck(email))
  {
document.getElementById("email").select();
  document.getElementById("email").focus();
   return false;
 }
 

 if(pass1!=pass2)
{
msg="Password and Confirm password mismatch.";
alert(msg);
document.getElementById("pass1").select();
document.getElementById("pass1").focus();
return false;
}

if(pass1!=="")
{

passx=pass1.length;

    if(passx<6)
    {
    alert("Password is too short! Password should be 6 characters minimum.");
document.getElementById("pass1").select();
document.getElementById("pass1").focus();
    return false;
    }

}


 var fileToUse = 'functions.php';
 cp.call(fileToUse,'chkprofileupdate',get_chkprofileupdate,uname,fname,lname,email,oldpass,pass1,pass2,userid);
return false;
}

function get_chkprofileupdate(result)
    {
        var msg=result.getElementsByTagName('msg').item(0).firstChild.data;
        var id=result.getElementsByTagName('id').item(0).firstChild.data;
        if(id==1)
        {
        document.getElementById("error").style.display="block";
        document.getElementById("sucmsgid").innerHTML=msg;
        }
        else
        {
         document.getElementById(id).select();
        document.getElementById(id).focus();
        document.getElementById("error").style.display="block";
        document.getElementById("msgid").innerHTML=msg;
        }       
    }
	
	        function output(result)
        {
            
            var msg=result.getElementsByTagName('response').item(0).firstChild.data;                                    
            var fid=result.getElementsByTagName('fid').item(0).firstChild.data;
            var amtArray = fid.split("|");
            for(i=0;i<amtArray.length;i++)
            {
                if(amtArray[i] && amtArray[i]!="on")
                
                document.getElementById(amtArray[i]).style.display="none";
                
            }
            document.getElementById("error").style.display="block";
            document.getElementById("sucmsgid").innerHTML=msg;
            
        }
		
		function check_all(name,formid) {
        
        formblock= document.getElementById(formid);
        forminputs = formblock.getElementsByTagName('input');
        
        for (i = 0; i < forminputs.length; i++) 
        {
                // regex here to check name attribute
                var regex = new RegExp(name, "i");
                if (regex.test(forminputs[i].getAttribute('name'))) 
                {
                        if (forminputs[i].checked ) 
                        {
                                forminputs[i].checked = false;
                        } else 
                        {
                                forminputs[i].checked = true;
                        }
                }
        }
        return false;
}

    function verifyAction(message) {

        return confirm(message)

    }