<?php
// Start the session
session_start();
$idU = $_SESSION['idU'];
$role = $_SESSION['Role'];
$showProductID = $_SESSION["showProductID"];
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "db_shop";





$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Prepare and bind the SQL statement
$stmt = $conn->prepare("SELECT * FROM products where idP = ?");
$stmt->bind_param("s", $showProductID);
// Execute the SQL statement
$stmt->execute();
$result = $stmt->get_result();

// Fetch products and output as JSON
$articles = array();
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc(); 
    // header('Content-Type: application/json');
    // echo json_encode($article);
    
}else{
    echo "error idp";
}
header('Content-Type: application/json');
    echo json_encode($product);    

?>