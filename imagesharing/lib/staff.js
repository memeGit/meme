var cp = new cpaint();
cp.set_transfer_mode('get');
cp.set_response_type('xml');
cp.set_debug(0);

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
               cp.call(fileToUse,'delete',output,chkid);               
        }
		
		function s_delete1image() {
		if(!confirm('Are you sure you want to delete this photo?'))
        return false;
   var d_filename=document.getElementById("d_filename").value;

   
 var fileToUse = 'functions.php';
 cp.call(fileToUse,'delete1image',get_delete1image,d_filename);
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
	
	function chk_update()
{
   var uid=document.getElementById("uid").value;
   var uname=document.getElementById("uname").value;
   var fname=document.getElementById("fname").value;
   var lname=document.getElementById("lname").value;
   var email = document.getElementById("email").value;
   var usergid = document.getElementById("usergid").value;
   var status = document.getElementById("status").value;
   var pass=document.getElementById("pass").value;

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
 

 var fileToUse = 'functions.php';
 cp.call(fileToUse,'chkupdate',get_chkupdate,uid,uname,fname,lname,email,usergid,status,pass);
return false;
}

function get_chkupdate(result)
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
	
function deletereport() {
        if(!confirm('Are you sure you want to delete the selected reports?'))
        return false;
        formblock= document.getElementById("reports");
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
            cp.call(fileToUse,'deletereport',outputreport,chkid);               
        }
function outputreport(result)
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
		
		        function deleteuser() {
        if(!confirm('Are you sure you want to delete the selected users?'))
        return false;
                formblock= document.getElementById("users");
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
               cp.call(fileToUse,'deleteuser',get_deleteuser,chkid);               
        }

        function activateuser(status) {

                formblock= document.getElementById("users");
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
               cp.call(fileToUse,'activateuser',get_activateuser,chkid,status);
        }
		
		
		        function changeusergroup(group) {

                formblock= document.getElementById("users");
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
               cp.call(fileToUse,'changeusergroup',get_changeusergroup,chkid,group);
        }
		
		
		

        function get_deleteuser(result)
        {
            
            var msg=result.getElementsByTagName('response').item(0).firstChild.data;                        
            var fid=result.getElementsByTagName('fid').item(0).firstChild.data;
            var amtArray = fid.split("|");
            for(i=0;i<amtArray.length;i++)
            {
                if(amtArray[i] && amtArray[i]!="on")
                
                document.getElementById("u_"+amtArray[i]).style.display="none";
                
            }
            document.getElementById("error").style.display="block";
            document.getElementById("sucmsgid").innerHTML=msg;
            
        }
        
        function get_activateuser(result)
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
		
		function chkfield()
{
   var uname=document.getElementById("uname").value;
   var url=document.getElementById("name").value;
   var host=document.getElementById("host").value;
   var pass=document.getElementById("pass").value;
   var dir=document.getElementById("dir").value;
   
   if(url=="")
   {
        msg="Server url cannot be left empty.";
        alert(msg);        
        document.getElementById("name").focus();
        return false;
    }
if(dir=="")
   {
        msg="Server dir cannot be left empty.";
        alert(msg);        
        document.getElementById("dir").focus();
        return false;
    }
   
   if(host=="")
   {
    var msg="Host address cannot be left empty.";
    alert(msg);
    document.getElementById("host").select();
    document.getElementById("host").focus();
   return false;
   }
   if(uname=="")
   {
    var msg="User Name cannot be left empty.";
    alert(msg);
    document.getElementById("uname").select();
    document.getElementById("uname").focus();
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
return true;
}

function ftpstatus(id,status) {
            var fileToUse = 'functions.php';               
            cp.call(fileToUse,'ftpstatus',get_ftpstatus,id,status);               
        }


        function get_ftpstatus(result)
        {

            var msg=result.getElementsByTagName('response').item(0).firstChild.data;
            var ftpid=result.getElementsByTagName('ftpid').item(0).firstChild.data;
            var status=result.getElementsByTagName('status').item(0).firstChild.data;
            document.getElementById("s_"+ftpid).innerHTML=status;
            document.getElementById("error").style.display="block";
            document.getElementById("sucmsgid").innerHTML=msg;

        }
    
function deleteftpSingle(chk) {
            if(!confirm('Are you sure you want to delete the selected server?'))
            return false; 
            chk="|"+chk;
            var fileToUse = 'functions.php';               
            cp.call(fileToUse,'deleteftp',outputftp,chk);               
        }
function deleteftp() {
        if(!confirm('Are you sure you want to delete the selected servers?'))
        return false;
        formblock= document.getElementById("servers");
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
            cp.call(fileToUse,'deleteftp',outputftp,chkid);               
        }
function outputftp(result)
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