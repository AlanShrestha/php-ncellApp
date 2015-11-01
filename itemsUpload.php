<?php
require("config.inc.php");

if(!empty($_POST))
{
 $imagedata = file_get_contents($_POST['imagePath']);
 $base64 = base64_encode($imagedata);
 
 $query = "INSERT INTO food (name, imageCaption, image, article) VALUES  (:Name, :ImageCaption, :Image, :Article)";
 $query_params = array(':Name' => $_POST['foodName'], ':ImageCaption' => $_POST['imageCaption'], ':Image' => $base64, ':Article' => $_POST['article']);

 try{
 $stmt = $db->prepare($query);
 $result = $stmt->execute($query_params);
 echo "done, check your database";
 }catch(PDOException $ex){
 echo "failure, check your code!";
 }
 
}

else{
?>
<h1>Load Food</h1>
<form action="itemsUpload.php" method="post">
 Food Name:<br/>
 <input type = "text" name = "foodName" value=""/><br/>
Image Caption:<br/>
 <input type = "text" name = "imageCaption" value=""/><br/>
Image Path:<br/>
 <input type = "text" name = "imagePath" value=""/><br/>
Description:<br/>
 <input type = "text" name = "article" value=""/>
<br/><br/>
 <input type ="submit" value="get info" />
</form>
<?php
}
?>
