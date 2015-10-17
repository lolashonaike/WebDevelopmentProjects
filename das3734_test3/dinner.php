<?php

if ($_POST["whatAction"] != "")
{
   $host = "fall-2014.cs.utexas.edu";
   $user = "shonaike";
   $pwd = "w70+Fkqcfe";
   $dbs = "cs329e_shonaike";
   $port = "3306";

   $connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
   if (empty($connect))
   {
     die("mysqli_connect failed: " . mysqli_connect_error());
   } 

   $table = "Dinner";
   if ($_POST["whatAction"] == "view")
   {
     $name = $_POST['NAME'];
     $items = $_POST['ITEMS'];
     $all = $_POST['all'];
     view($name1,$items,$all,$connect,$table);
   }
   if  ($_POST["whatAction"] == "insert")
   {
     $name = $_POST['NAME'];
     $items = $_POST['ITEMS'];
     $all = $_POST['all'];
     view($name1,$items,$all,$connect,$table);

     if ($name != '' && $items != '')
     {
        insert($name,$items,$connect,$table);
     }
     else
     {
        errorPage1();
     }
   }
   if ($_POST["whatAction"] == "update")
   {
     $name = $_POST['NAME'];
     $items = $_POST['ITEMS'];
     view($name1,$items,$all,$connect,$table);

     if ($name != '' && $items != '')

     {
        update($name,$items,$connect,$table);
     }
     else
     {
       errorPage2();
     }
   }
   if ($_POST["whatAction"] == "delete")
   {
     $name1 = $_POST['name1'];
      view($name1,$items,$all,$connect,$table);

     delete($id,$connect,$table);
   }
}

if ($_POST['page'] == "trial")
{
    $password = $_POST["password"];
    $username = $_POST["username"];
    $isInFile = False;
    $file = fopen("./password3.txt","r");
    while(!feof($file))
    {
       $line = fgets($file);
       if(preg_match("/{$username}/",$line)){
            $str = preg_split ("/:/",$line);
            $string = str_replace(array("\n","\r"), '',$str[1]);
            if($password == $string)
            {
               $isInFile = True;
            }
            break;
       }
    }
    fclose();
    if ($isInFile == True)
    {
        selectionPage();
    }
    else
    {
        failedPage();
    }

}
elseif ($_POST['page'] == "insert")
{
  insertStudentRecord();
}
elseif ($_POST['page'] == "update")
{
   updateStudentRecord();

}
elseif ($_POST['page'] == "delete")
{
   deleteStudentRecord();
}
elseif ($_POST['page'] == "view")
{
   viewStudentRecord();

}
elseif ($_POST['page'] == "logout")
{
  thankYouPage();
}
else
{
   if($_POST['whatAction'] == "")
   {
      logIn();
   }
}

function errorPage1()
{
  $script = $_SERVER['PHP_SELF'];
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
}

function errorPage2()
{
  $script = $_SERVER['PHP_SELF'];
  print <<<TOP
  <html>
  <head>
  <title> Interm Page </title>
  </head>
  <body>
  <center>
  <form method = "post" action = "$script">
  <p> 
  You failed to fill in at least one entry <br />
  Please return to Update Page and try again 
  </p>
  <input type = "hidden" name = "page" value = "update" />
  <input type = "submit" name = "done" value = "Back to Update Page" />
  </center>
  </body>
  </html>
TOP;
}

function view($name,$items,$all,$connect,$table)
{
   print $name;
   if ($name != '' && $all == "")
   {
      $results = mysqli_query($connect, "SELECT * FROM $table WHERE Name='$name'");
   }
   elseif ($name == "" && $items == "" && $all == "")
   {
      $results = mysqli_query($connect, "SELECT * FROM $table WHERE Items='$items'");
   }
   
   else
   {
      $results = mysqli_query($connect, "SELECT * FROM $table");
   }
   $sript = $_SERVER['PHP_SELF'];
   print <<<TOP
   <html>
   <head>
   <title> Results Page </title>
   <link href="dinner.css" rel="stylesheet">
   </head>
   <body>
   <center>
   <h1> Results for Dinner </h1>
   <table>
   <tr><td>Name</td><td>Items</td></tr>
TOP;

   while ($row = $results->fetch_row())
   {
      print "<tr> <td> " .$row[0]."</td><td>".$row[1]."</td></tr>";
   }
   $results->free();
   print <<<BOTTOM
   </table>
   <form method = "post" action = "$script">
   <input type = "hidden" name = "page" value = "logout" />
   <input type = "submit" name = "done" value = "Finished" />
   </form>
   </center>
   </body>
   </html>
BOTTOM;

}

function insert($name,$items,$connect,$table)
{
  $script = $_SERVER['PHP_SELF'];
  mysqli_query($connect, "INSERT INTO $table VALUES ('$name','$items')");
  print <<<TOP
  <html>
  <head>
  <title> Interm Page </title>
  </head>
  <body>
  <center>
  <form method = "post" action = "$script">
  <input type = "hidden" name = "page" value = "logout" />
  <input type = "submit" name = "done" value = "Finished" />
  </center>
  </body>
  </html>
TOP;
}

function update($name,$items,$connect,$table)
{

  $script = $_SERVER['PHP_SELF'];
  if ($name1 != '')
  {
     mysqli_query($connect, "UPDATE $table SET LAST='$name' WHERE Name='$name'");
  }
  if ($items != '')
  {
     mysqli_query($connect, "UPDATE $table SET FIRST='$items' WHERE Items='$items'");
  }
 
  print <<<TOP
  <html>
  <head>
  <title> Interm Page </title>
  </head>
  <body>
  <center>
  <form method = "post" action = "$script">
  <input type = "hidden" name = "page" value = "logout" />
  <input type = "submit" name = "done" value = "Finished" />
  </center>
  </body>
  </html>
TOP;
}

function delete($name1,$connect,$table)
{
  
  $script = $_SERVER['PHP_SELF'];
  mysqli_query($connect, "DELETE FROM $table WHERE Name=$name");
  print <<<TOP
  <html>
  <head>
  <title> Interm Page </title>
  </head>
  <body>
  <center>
  <form method = "post" action = "$script">
  <input type = "hidden" name = "page" value = "logout" />
  <input type = "submit" name = "done" value = "Finished" />
  </center>
  </body>
  </html>
TOP;
}



function logIn()
{
   $script = $_SERVER['PHP_SELF'];
   print <<<p
   <html>
   <head>
   <title> Log On </title>
     <script type="text/javascript" src="./dinner.js"></script>
     <link href="dinner.css" rel="stylesheet">
   </head>
 

   <center>
   <h2> Log On/Registration Form </h2>
   </center> 
   <form id="checkIT" method = "post" action="$script">
   <table>
   <tr>
   <td> Enter Name </td>
   <td> <input type="text" name="username" value="" size="30"/> </td>
   </tr>
   <tr>
   <td> Password </td>
   <td> <input type="text" name="password" value="" size="30"/> </td>
   </tr>
  
    <tr><td> <input type = "submit" name= "reg" value="Log On" onsubmit="checkForm();" />
   <input type = "hidden" name = "page" value="trial" /></td>
   <td><input type = "reset" value="Clear" /></td></tr>
    </table>
   </form>
  
   </html>
p;
}

function selectionPage()
{
  $sript = $_SERVER['PHP_SELF'];
  
  print <<<TOP
  <html> 
  <head>
  <title> Selection Page </title>
  </head>
  <body>
  <center>
  <h1> Options </h1>
  <form method = "post" action = "$script" >
  <input type = "submit" name = "page" value = "insert" />
  <input type = "submit" name = "page" value = "update" />
  <input type = "submit" name = "page" value = "delete" />
  <input type = "submit" name = "page" value = "view" />
  <input type = "submit" name = "page" value = "logout" />
  </form>
  </center>
  </body>
  </html>

TOP;

}

function failedPage()
{
   $sript = $_SERVER['PHP_SELF'];
   print <<<TOP
   <html>
   <head>
   <title> Log On Failed </title>
   </head>
   <body>
   <center>
   <h1> Login Failed </h1>
   <form method = "post" action = "$script">
   <input type = "hidden" name = "page" value = "" />
   <input type = "submit" name = "backToLogIn" value = "Back to Log In" />
   </form>
   </center>
   </body>
   </html>
TOP;
}

function viewStudentRecord()
{

   $sript = $_SERVER['PHP_SELF'];
   print <<<TOP
   <html>
   <head>
   <title> View Students Record </title>
   </head>
   <body>
   <center>
   <h1> View Students </h1>
   <form method = "post" action = "$script">
   <label>
   Name: 
   <input type = "text" name = "NAME" />
   </label>
   <label>
   Items: 
   <input type = "text" name = "ITEMS" />
   </label>
  
   <br />
   <br />
   <input type = "hidden" name = "whatAction" value = "view" />
   <input type = "submit" name = "done" value = "Done" />
   <input type = "submit" name = "all" value = "View All Student Records" />
   <input type = "reset" value = "Clear" />
   </form>
   </center>
   </body>
   </html>
TOP;
}


function insertStudentRecord()
{
   $sript = $_SERVER['PHP_SELF'];
   print <<<TOP
   <html>
   <head>
   <title> Insert Students Record </title>
   </head>
   <body>
   <center>
   <h1> Insert Student </h1>
   <form method = "post" action = "$script">
   <label>
   Name: 
   <input type = "text" name = "NAME" />
   </label>
   <label>
   Items: 
   <input type = "text" name = "ITEMS" />
   </label>
  
   <br />
   <br />
   <input type = "hidden" name = "whatAction" value = "insert" />
   <input type = "submit" name = "done" value = "Done" />
   <input type = "reset" value = "Clear" />
   </form>
   </center>
   </body>
   </html>
TOP;

}

function updateStudentRecord()
{
   $sript = $_SERVER['PHP_SELF'];
   print <<<TOP
   <html>
   <head>
   <title> Update Dinner </title>
   </head>
   <body>
   <center>
   <h1> Update Items </h1>
   <form method = "post" action = "$script">
   <label>
   Name: 
   <input type = "text" name = "NAME" />
   </label>
   <label>
   Items: 
   <input type = "text" name = "ITEMS" />
   </label>
  
   <br />
   <br />
   <input type = "hidden" name = "whatAction" value = "update" />
   <input type = "submit" name = "done" value = "Done" />
   <input type = "reset" value = "Clear" />
   </form>
   </center>
   </body>
   </html>
TOP;
}

function deleteStudentRecord()
{
  
   $sript = $_SERVER['PHP_SELF'];
   print <<<TOP
   <html>
   <head>
   <title> Delete Dinner Record </title>
   </head>
   <body>
   <center>
   <h1> Delete Name and Item </h1>
   <form method = "post" action = "$script">
   <label>
   Name: 
   <input type = "text" name = "NAME" />
   </label>
   <br />
   <br />
   <input type = "hidden" name = "whatAction" value = "delete" />
   <input type = "submit" name = "done" value = "Done" />
   <input type = "reset" value = "Clear" />
   </form>
   </center>
   </body>
   </html>
TOP;
}

function thankYouPage()
{
   print <<<TOP
   <html>
   <head>
   <title> Thank You Page </title>
   </head>
   <body>
   <center>
   <h1> Thank You </h1>
   </center>
   </body>
TOP;
}


?>