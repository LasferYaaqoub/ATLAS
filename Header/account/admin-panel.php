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

// Retrieve user data from the database
$sql = "SELECT username, email FROM users";
$result = $conn->query($sql);
$users = array();
if ($result->num_rows > 0) {
    // Fetch user data
    while ($user = $result->fetch_assoc()) {
        $users[] = $user;
    }
    // Output the articles as JSON
    header('Content-Type: application/json');
    echo json_encode($users);
    
    // Output user data as HTML
    // echo "<h2>Welcome, " . $row['username'] . "!</h2>";
    // echo "<p>Email: " . $row['email'] . "</p>";
} else {
    echo "<p>User not found</p>";
}

// Display the data in a table
// echo "<table>";
// echo "<tr><th>Username</th><th>Email</th><th>Action</th></tr>";
// if ($result->num_rows > 0) {
//     // while($row = $result->fetch_assoc()) {
//     //     echo "<tr>";
//     //     echo "<td>" . $row["username"] . "</td>";
//     //     echo "<td>" . $row["email"] . "</td>";
//     //     echo "<td><button onclick='confirmDelete(\"" . $row["username"] . "\")'>Delete</button></td>";
//     //     echo "</tr>";
//     // }

// } else {
//     echo "<tr><td colspan='3'>No users found</td></tr>";
// }
// echo "</table>";

$conn->close();
?>