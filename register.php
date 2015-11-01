
<?php
require("config.inc.php");

if(!empty($_POST))
 {
  if(empty($_POST['username']) || empty($_POST['password']))
  {
   $response["success"] = 0;
   $response["message"] = "please enter both a username and a password.";
   //echo $response["message"];
   //die();
   die(json_encode($response));
  }

  $query = "SELECT 1 FROM users WHERE username = :user";
  $query_params = array(':user' =>$_POST['username']);
  try{
  $stmt = $db -> prepare($query);
  $result = $stmt -> execute($query_params);
  }
  catch(PDOException $ex){
  $response["success"]=0;
  $response["message"]="Database Error.Please Try again!";
  //echo $response["message"];
  //die();
  die(json_encode($response));
  }

  $row=$stmt->fetch();
  if($row){
  $response["success"]=0;
  $response["message"]="I'm sorry, this username is already in use";
  //echo $response["message"];
  //die();
  die(json_encode($response));
  }
  
  $query = "INSERT INTO users (username,password) VALUES (:user, :pass)";
  $query_params = array(':user' => $_POST['username'],
                       ':pass' => sha1($_POST['password']));

  try{
   $stmt = $db ->prepare($query);
   $result = $stmt->execute($query_params);  
}
  catch(PDOException $ex){
   $response["success"]=0;
   $response["message"]="Database Error2.Please Try";
   //echo $response["message"];
   //die();
   die(json_encode($response));
  }

  $response["success"] = 1;
  $response["message"] = "Username Successfully Added!";
  //echo $response["message"];
  
  echo json_encode($response); 
  
 }
else
 {
 ?>
<h1>Register</h1>
<form action="register.php" method="post">
 Username:<br/>
 <input type = "text" name = "username" value=""/>
 <br /><br/>
 Password:<br />
 <input type="password" name="password" value="" />
 <br /><br />
 <input type ="submit" value="Register New User" />
</form>
 <?php
 }
?>

