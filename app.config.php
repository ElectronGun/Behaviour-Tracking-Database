<?php 

  // Config file contains "configuration information", in this case the 
  // configuration information required to connect to a database.  The 
  // config file also makes the connection to a database.
  
  // configuration values related to database name, username, password and host
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "tracker";
  $dbhost = "localhost";
  
  // Declare/use a global variable $conn
  //
  // See php.net: https://www.php.net/manual/en/language.variables.scope.php
  // 
  // We'll use this to as our connection to the database, and our model will
  // also use this global variable
  //
  global $conn;
  

  // Attempt to make a connection to the database using the above config info
  try
  {
    // returns an object representing our connection to the database
    $conn = new PDO("mysql:host=" . $dbhost .  ";dbname=" . $dbname, 
                          $dbusername, $dbpassword);
  }
  catch (PDOException $e)
  {
    // if the above attempt to connect fails it will be "caught" by this block
    // of code, where we can then output the error message
    echo "Connection failed: " . $e->getMessage();
    exit();
  }

?>