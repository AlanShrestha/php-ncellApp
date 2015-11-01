<?php
 $username = "root";
 $password = "";
 $host = "localhost";
 $dbname = "Tourbook";

try
{e
 $db = new PDO("mysql:host = $host;dbname=$dbname", $username, $password);
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 $query = "INSERT INTO users (id,username,password) VALUES ( 1,'ram', 'shyam')";
 $db->exec($query);
 echo "success";
}
  catch(PDOException $ex){
  echo $query."<br>".$ex->getMessage();
  }
 $db=null;
?>
