<?php

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

   $username = $_GET["username"];
  
   $table = "CALENDAR";
   $results = mysqli_query($connect, "SELECT * FROM $table WHERE NAME='$username'");
   $row = $results->fetch_row();
   echo $row[0];
   


?>
