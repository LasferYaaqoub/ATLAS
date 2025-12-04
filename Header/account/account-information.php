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

// Prepare SQL statement
$stmt = $conn->prepare("SELECT * FROM users WHERE idU = ?");
if (!$stmt) {
    die("Error in preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("i", $idU);

// Execute statement
$stmt->execute();

// Get result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch user data
    $user = $result->fetch_assoc();
    // Output the articles as JSON
    header('Content-Type: application/json');
    echo json_encode($user);
    
    // Output user data as HTML
    // echo "<h2>Welcome, " . $row['username'] . "!</h2>";
    // echo "<p>Email: " . $row['email'] . "</p>";
} else {
    echo "<p>User not found</p>";
}

// Close statement and connection
$stmt->close();
$conn->close();
















// // Start the session
// session_start();

// // Check if the idU session variable is set
// if (!isset($_SESSION['idU'])) {
//     // Handle the case where idU is not set (redirect or display an error)
//     echo "User ID not found.";
//     exit;
// }

// // Retrieve user ID from session
// $idU = $_SESSION['idU'];

// // Connect to MySQL database
// $servername = "localhost";
// $dbUsername = "root";
// $dbPassword = "";
// $dbName = "db_shop";

// $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Retrieve user information from the database
// $stmt = "SELECT * FROM users WHERE idU = ?"; 
// $stmt->bind_param("i", $idU);
// $stmt->execute();
// $result = $conn->query($stmt);
// // $user = array();
// if ($result->num_rows > 0) {
//     // Fetch user data
//     $user = $result->fetch_assoc();
//     // Output the articles as JSON
//     header('Content-Type: application/json');
//     echo json_encode($user);
    
//     // Output user data as HTML
//     // echo "<h2>Welcome, " . $row['username'] . "!</h2>";
//     // echo "<p>Email: " . $row['email'] . "</p>";
// } else {
//     echo "<p>User not found</p>";
// }

// $conn->close();
?>
