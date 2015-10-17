
function checkForm()
{
 var elt= document.getElementById("checkIT");
 if (elt.user.value =="" || elt.password.value==""){
 alert("Please make sure that you filled all fields");
 return false;
}
}