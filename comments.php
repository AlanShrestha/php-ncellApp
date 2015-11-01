<?php

require("config.inc.php");

if($_POST['request'] == "getComments")
{

$query = "SELECT food_id FROM food WHERE name = :item";
$query_params = array(':item' => $_POST['item']);
try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error1!";
    die(json_encode($response));
}

$foodId = $stmt->fetch();

$query = "SELECT comments.comment, users.username 
FROM comments
LEFT JOIN users
ON comments.users_id = users.users_id
WHERE comments.food_id = :foodid";

$query_params = array(':foodid' => $foodId["food_id"]);

//execute query
try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error!";
    die(json_encode($response));
}

$rows = $stmt->fetchAll();

if ($rows) {
    $response["success"] = 1;
    $response["message"] = "Post Available!";
    $response["comments"]   = array();
    
    foreach ($rows as $row) {
        $post = array();
        $post["username"]  = $row["username"];
        $post["comment"] = $row["comment"];
        
        //update our repsonse JSON data
        array_push($response["comments"], $post);
    }
    
    // echoing JSON response
    echo json_encode($response);
    
    
} else {
    $response["success"] = 0;
    $response["message"] = "No Post Available!";
    die(json_encode($response));
}
}
elseif($_POST['request'] == "postComments"){

$query = "SELECT users_id FROM users WHERE username = :username";
$query_params = array(':username' => $_POST['username']);
try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error 1!";
    die(json_encode($response));
}
$userId = $stmt->fetch();

$query = "SELECT food_id FROM food WHERE name = :item";
$query_params = array(':item' => $_POST['item']);
try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error 2!";
    die(json_encode($response));
}
$foodId = $stmt->fetch();


$query = "INSERT INTO comments(comment, food_id, users_id) VALUES (:comment, :food_id, :users_id)";
$query_params = array(':comment' => $_POST['comment'], ':food_id' => $foodId["food_id"], ':users_id' =>$userId["username"]);
try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error 3!";
    die(json_encode($response));
}
}

?>
