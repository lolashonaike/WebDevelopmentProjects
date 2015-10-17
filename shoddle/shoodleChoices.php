<?php

session_start();



if ($_POST["whatAction"] != "")
{
   $host = "fall-2014.cs.utexas.edu";
   $user = "tcox1990";
   $pwd = "31AoaSQyLz";
   $dbs = "cs329e_tcox1990";
   $port = "3306";

   $connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
   if (empty($connect))
   {
     die("mysqli_connect failed: " . mysqli_connect_error());
   } 

   $table = "CALENDAR";
      if  ($_POST["whatAction"] == "insert")
   {
     $NAME = $_POST['NAME'];
     $TIME = $_POST['TIME'];
     $EVENT = $_POST['EVENT'];
     if ($NAME != '' && $TIME != '' && $EVENT != '')
     {
        insert($NAME,$TIME,$EVENT,$connect,$table);
     }
     else
     {
        errorPage1();
     }
   }
}   
else
{
    $_SESSION["number"] = 1;
    insertStudentRecord();
}

function errorPage1()
{
  $script = $_SERVER['PHP_SELF'];
  $number = $_SESSION["number"];
  print "session number it {$number}";
  $_SESSION["number"] = $number+1;
  
  print <<<TOP
  <html>
  <head>
  <title> Interm Page </title>
  </head>
  <body>
  <center>
  <form method = "post" action = "$script">
  <p> 
  You failed to fill in one or more entry <br />
  Please return to Insert Page and try again 
  </p>
  <input type = "hidden" name = "page" value = "insert" />
  <input type = "submit" name = "done" value = "Back to Insert Page" />
  </center>
  </body>
  </html>
TOP;
  session_destroy();
}


function insert($NAME,$TIME,$EVENT,$connect,$table)
{

  mysqli_query($connect, "INSERT INTO $table VALUES ('$NAME','$TIME','$EVENT')");
  $number = $_SESSION["number"];
  print "session number it {$number}";
  $_SESSION["number"] = $number+1;  
  print <<<TOP
  <html>
  <head>
  <title> Interm Page </title>
  </head>
  <body>
  <center>
  <a href="./day1.html"> Go Back to Main Page</a>

  </center>
  </body>
  </html>
TOP;
}
function insertStudentRecord()
{
   $event = $_GET["EVENT"];
   $time =$_GET["TIME"];
   $number = $_SESSION["number"];
   print "session number it {$number}";
   $_SESSION["number"] = $number+1;

   $sript = $_SERVER['PHP_SELF'];
   print <<<TOP
   <html>
   <head>
   <title> Confirm Event and Time  </title>
   </head>
   <body>
   <center>
   <h1> Insert Student </h1>
   <form method = "post" action = "$script">
   <label>
  Username:
   <input type = "text" name = "NAME" />
   </label>
   <label>
   Time: 
   <input type = "text" name = "TIME" value= "{$time}" />
   </label>
   <label>
   Event: 
   <input type = "text" name = "EVENT" value="{$event}" />
   </label>
   
   <br />
   <br />
   <input type = "hidden" name = "whatAction" value = "insert" />
   <input type = "submit" name = "done" value = "Confirm Information" />
   <input type = "reset" value = "Clear" />
   </form>
   </center>
   </body>
   </html>
TOP;

}



?>
