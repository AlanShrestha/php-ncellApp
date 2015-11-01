
<?php
require("config.inc.php");

if(!empty($_POST)){
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

//echo json_encode($foodId);

$query = "SELECT foodLocations.food_id, places.name, places.location
FROM foodLocations
LEFT JOIN places
ON foodLocations.places_id = places.places_id
WHERE foodLocations.food_id = :foodid";

$query_params = array(':foodid' => $foodId["food_id"]);

try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error!";
    die(json_encode($response));
}

// Finally, we can retrieve all of the found rows into an array using fetchAll 
$rows = $stmt->fetchAll();


if ($rows) {
    $response["success"] = 1;
    $response["message"] = "Post Available!";
    $response["posts"]   = array();
    
    foreach ($rows as $row) {
        $post = array();
        $post["food_id"]  = $row["food_id"];
        $post["name"] = $row["name"];
        $post["location"]    = $row["location"];
        
        //update our repsonse JSON data
        array_push($response["posts"], $post);
    }
    
    // echoing JSON response
    echo json_encode($response);
    
    
} else {
    $response["success"] = 0;
    $response["message"] = "No Post Available!";
    die(json_encode($response));
}
}
else{
?>
<h1>Search Food</h1>
<form action="places.php" method="post">
 Food Name:<br/>
 <input type = "text" name = "item" value=""/>
<br/><br/>
 <input type ="submit" value="get info" />
</form>
<?php
}
?>
