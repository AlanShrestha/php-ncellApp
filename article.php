<?php
require("config.inc.php");
if(!empty($_POST)){
 $query = "SELECT * FROM food WHERE name = :foodName";
 $query_params = array(':foodName' => $_POST['foodName']);
 try{
 $stmt = $db->prepare($query);
 $stmt->execute($query_params);
 }catch(PDOException $e){
 $response["success"]=0;
 $response["message"]="failed to retrieve data";
 die(json_encode($response));
 }
 $row = $stmt->fetch();
 $response["success"]=1;
 $response["name"]= "name";
 $response["food_id"]= $row["food_id"];
 $response["imageCaption"]= $row["imageCaption"];
 $response["image"] = $row["image"];
 $response["article"] = $row["article"];
 echo json_encode($response);
}
else{
?>
<h1>Search Food</h1>
<form action="article.php" method="post">
 Food Name:<br/>
 <input type = "text" name = "foodName" value=""/>
<br/><br/>
 <input type ="submit" value="get info" />
</form>
<?php
}
?>
