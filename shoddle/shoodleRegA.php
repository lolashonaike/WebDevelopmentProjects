<?php

$username = $_POST["username"];
$password = $_POST["password"];
$isInFile = False;
$file = fopen("./passwd.txt","r");
while(!feof($file))
{
   $line = fgets($file);
   if(preg_match("/{$username}/",$line)){
       if(preg_match("/{$password}/",$line)){
          $isInFile = True;
       }
    }
}
fclose();
if ($isInFile == True){
    print <<<top
    <html>
    <head>
    <title> Valid Page </title>
    </head>
    <body>
    <center>
    <a href="./day1.html"> Main Page </a>
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
    <a href="./Shoddle.html"> Invalid username or password. Back to Shoodle </a>
    </center>
    </body>
    </html>
top;
}
?>
