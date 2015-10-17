<?php

$username = $_POST["user"];
$password = $_POST["pass"];
$file = fopen("./passwd.txt","r");
$isInFile = False;
while(!feof($file))
{
   $line = fgets($file);
   if(preg_match("/{$username}/",$line)){
       $isInFile = True;
    }
}
fclose();
if ($isInFile == False){
    $file = fopen("./passwd.txt","a");
    $str = $username.":".$password."\n";
    fputs($file,$str);
    fclose();
    print <<<top
    <html>
    <head>
    <title> Valid Page </title>
    </head>
    <body>
    <center>
    <h1> Your username and Password have been Registered </h1>
    </center>
    </body>
    </html>
top;
}
else{
    print <<<top
    <html>
    <head>
    <title> Invalid Page </title>
    </head>
    <body> 
    <center>
    <h1> Your Username already exists </h1>
    </center>
    </body>
    </html>
top;
}


?>
