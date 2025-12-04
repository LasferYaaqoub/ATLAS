<?php
// Start the session
session_start();

// Check if the idU session variable is set
if (!isset($_SESSION['idU'])) {
    // Handle the case where idU is not set (redirect or display an error)
    echo "User ID not found.";
    exit;
}

// Retrieve user ID from session
$idU = $_SESSION['idU'];
$role = $_SESSION["Role"];

// Connect to MySQL database
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "db_shop";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Prepare the SQL query
$sql = "SELECT * FROM products";
if ($role == "user") {
    $sql .= " WHERE legal = ?";
}
$sql .= " ORDER BY updated_at DESC";

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
if ($role == "user") {
    $legal = true; // Set the value to bind
    $stmt->bind_param("s", $legal); // Pass the variable $legal by reference
}
$stmt->execute();
$result = $stmt->get_result();

// Fetch products and output as JSON
$articles = array();
if ($result->num_rows > 0) {
    while ($article = $result->fetch_assoc()) {
        $articles[] = $article;
    }
}
header('Content-Type: application/json');
echo json_encode($articles);



// Close the statement and database connection
$stmt->close();
$conn->close();
?>
