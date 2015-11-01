<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tourbook";

try {
    $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    $sql = "";

    $conn->exec($sql);
    echo "Table created successfully";

    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?> 
