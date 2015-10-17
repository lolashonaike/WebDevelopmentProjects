<?php

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

   $table = "STUDENTS";
   if ($_POST["whatAction"] == "view")
   {
     $id = $_POST['ID'];
     $last = $_POST['LAST'];
     $first = $_POST['FIRST'];
     $all = $_POST['all'];
     view($id,$last,$first,$all,$connect,$table);
   }
   if  ($_POST["whatAction"] == "insert")
   {
     $id = $_POST['ID'];
     $last = $_POST['LAST'];
     $first = $_POST['FIRST'];
     $major = $_POST['MAJOR'];
     $gpa = $_POST['GPA'];
     if ($id != '' && $last != '' && $first != '' && $major != '' && $gpa != '')
     {
        insert($id,$last,$first,$major,$gpa,$connect,$table);
     }
     else
     {
        errorPage1();
     }
   }
   if ($_POST["whatAction"] == "update")
   {
     $id = $_POST['ID'];
     $last = $_POST['LAST'];
     $first = $_POST['FIRST'];
     $major = $_POST['MAJOR'];
     $gpa = $_POST['GPA'];
     if ($id != '' && ($last != '' || $first != '' || $major != '' || $gpa != ''))
     {
        update($id,$last,$first,$major,$gpa,$connect,$table);
     }
     else
     {
       errorPage2();
     }
   }
   if ($_POST["whatAction"] == "delete")
   {
     $id = $_POST['ID'];
     delete($id,$connect,$table);
   }
}

if ($_POST['page'] == "trial")
{
    $password = $_POST["password"];
    $username = $_POST["username"];
    $isInFile = False;
    $file = fopen("./password.txt","r");
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
  You failed to fill in at least one entry and/or the student's ID <br />
  Please return to Update Page and try again 
  </p>
  <input type = "hidden" name = "page" value = "update" />
  <input type = "submit" name = "done" value = "Back to Update Page" />
  </center>
  </body>
  </html>
TOP;
}

function view($id,$last,$first,$all,$connect,$table)
{
   print $id;
   if ($id != '' && $all == "")
   {
      $results = mysqli_query($connect, "SELECT * FROM $table WHERE ID='$id'");
   }
   elseif ($id == "" && $first == "" && $all == "")
   {
      $results = mysqli_query($connect, "SELECT * FROM $table WHERE LAST='$last'");
   }
   elseif ($id == "" && $last == "" && $all == "")
   {
      $results = mysqli_query($connect, "SELECT * FROM $table WHERE FIRST='$first'");
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
   </head>
   <body>
   <center>
   <h1> Results for Student </h1>
TOP;

   while ($row = $results->fetch_row())
   {
      print "<p> ID = " .$row[0]." Last = ".$row[1]." First = ".$row[2]." Major = ".$row[3]." GPA = ".$row[4]. "</p> <br /> <br />\n";
   }
   $results->free();
   print <<<BOTTOM
   <form method = "post" action = "$script">
   <input type = "hidden" name = "page" value = "logout" />
   <input type = "submit" name = "done" value = "Finished" />
   </form>
   </center>
   </body>
   </html>
BOTTOM;

}

function insert($id,$last,$first,$major,$gpa,$connect,$table)
{
  $script = $_SERVER['PHP_SELF'];
  mysqli_query($connect, "INSERT INTO $table VALUES ('$id','$last','$first','$major','$gpa')");
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

function update($id,$last,$first,$major,$gpa,$connect,$table)
{

  $script = $_SERVER['PHP_SELF'];
  if ($last != '')
  {
     mysqli_query($connect, "UPDATE $table SET LAST='$last' WHERE ID='$id'");
  }
  if ($first != '')
  {
     mysqli_query($connect, "UPDATE $table SET FIRST='$first' WHERE ID='$id'");
  }
  if ($major != '')
  {
     mysqli_query($connect, "UPDATE $table SET MAJOR='$major' WHERE ID='$id'");
  }
  if ($gpa != '')
  {
     mysqli_query($connect, "UPDATE $table SET GPA='$gpa' WHERE ID='$id'");
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

function delete($id,$connect,$table)
{
  
  $script = $_SERVER['PHP_SELF'];
  mysqli_query($connect, "DELETE FROM $table WHERE ID=$id");
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
   </head>
   <body>
   <center>
   <h2> Log On/Registration Form </h2>
   </center> 
   <form method = "post" action="$script">
   <table>
   <tr>
   <td> Enter Name </td>
   <td> <input type="text" name="username" size="30"/> </td>
   </tr>
   <tr>
   <td> Password </td>
   <td> <input type="text" name="password" size="30"/> </td>
   </tr>
   </table>
   <input type = "hidden" name = "page" value="trial" />
   <input type = "submit" value="Log On" />
   <input type = "reset" value="Clear" />
   </form>
   </body>
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
   ID: 
   <input type = "text" name = "ID" />
   </label>
   <label>
   LAST: 
   <input type = "text" name = "LAST" />
   </label>
   <label>
   FIRST: 
   <input type = "text" name = "FIRST" />
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
   ID: 
   <input type = "text" name = "ID" />
   </label>
   <label>
   LAST: 
   <input type = "text" name = "LAST" />
   </label>
   <label>
   FIRST: 
   <input type = "text" name = "FIRST" />
   </label>
   <label>
    MAJOR:
   <input type = "text" name = "MAJOR" />
   </label>
   <label>
   GPA:
   <input type = "text" name = "GPA" />
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
   <title> Update Students Record </title>
   </head>
   <body>
   <center>
   <h1> Update Student </h1>
   <form method = "post" action = "$script">
   <label>
   ID: 
   <input type = "text" name = "ID" />
   </label>
   <label>
   LAST: 
   <input type = "text" name = "LAST" />
   </label>
   <label>
   FIRST: 
   <input type = "text" name = "FIRST" />
   </label>
   <label>
    MAJOR:
   <input type = "text" name = "MAJOR" />
   </label>
   <label>
   GPA:
   <input type = "text" name = "GPA" />
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
   <title> Delete Students Record </title>
   </head>
   <body>
   <center>
   <h1> Delete Student </h1>
   <form method = "post" action = "$script">
   <label>
   ID: 
   <input type = "text" name = "ID" />
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
