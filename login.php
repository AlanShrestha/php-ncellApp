<?php
require("config.inc.php");

if(!empty($_POST)){
 $query = "SELECT users_id,username,password FROM users WHERE username = :username";
 $query_params = array(':username'=> $_POST['username']);
 try{
  $stmt = $db->prepare($query);
  $result = $stmt->execute($query_params);
 }catch(PDOException $ex){
  $response["success"] = 0;
  $response["message"] = "Database Error1";
  die(json_encode($response));
 }
 
 $login_ok=false;
 $row = $stmt->fetch();
 if(sha1($_POST['password']) === $row['password']){
 $login_ok = true;
 }
 if($login_ok){
  $response["success"] = 1;
  $response["message"] = "Login Successful!";
  die(json_encode($response));
 }else{
  $response["success"] = 0;
  $response["message"] = "Invalid Credentials!";
  die(json_encode($response));
 } 
}else{
?>
<h1>Login</h1>
<form action = "login.php" method = "post">
  Username:<br />
  <input type = "text" name= "username" placeholder="username" />
  <br /><br />
  Password:<br />
  <input type = "password" name= "password" placeholder="password" value=""/>
  <br /><br />
  <input type = "submit" value="Login" />
</form>
<a href = "register.php">Register</a>
<?php
}
?>
