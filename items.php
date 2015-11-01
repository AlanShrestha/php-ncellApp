
<?php
require("config.inc.php");

$query = "Select food_id, name FROM food";
//execute query
try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute();
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Unable to fetch items. Database Error";
    die(json_encode($response));
}

// Finally, we can retrieve all of the found rows into an array using fetchAll 
$rows = $stmt->fetchAll();


if ($rows) {
    $response["success"] = 1;
    $response["message"] = "Items Available!";
    $response["Items"]   = array();
    
    foreach ($rows as $row) {
        $post = array();
        $post["food_id"]  = $row["food_id"];
        $post["name"] = $row["name"];
        //$post["food_icon"]    = $row["food_icon"];
        
        //update our repsonse JSON data
        array_push($response["Items"], $post);
    }
    
    // echoing JSON response
    echo json_encode($response);
    
    
} else {
    $response["success"] = 0;
    $response["message"] = "No items Available!";
    die(json_encode($response));
}

?>
