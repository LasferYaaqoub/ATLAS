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

// Prepare and bind the SQL statement
$stmt = $conn->prepare("SELECT * FROM myarticles JOIN products ON myarticles.idP = products.idP WHERE idU = ?");
$stmt->bind_param("s", $idU);

// Execute the SQL statement
$stmt->execute();
$result = $stmt->get_result();
$articles = array();

// Check if articles are found for the user
if ($result->num_rows > 0) {
    // Loop through the result set and add article data to the array
    while ($article = $result->fetch_assoc()) {
        $articles[] = $article;
    }
}
// Output the articles as JSON
header('Content-Type: application/json');
echo json_encode($articles);

// Initialize HTML content variable
$htmlContent = '';

// Check if articles are found for the user
// if ($result->num_rows > 0) {
//     // Loop through the result set and generate HTML for each article
//     while ($article = $result->fetch_assoc()) {
//         $htmlContent .= '<div class="articles">';
//         $htmlContent .= '<img src="' . $article['image_url'] .  '" width="200" height="150" ">';
//         $htmlContent .= '<h3>' . $article['nameP'] . '</h3>';
//         $htmlContent .= '<p>' . $article['description'] . '</p>';
//         $htmlContent .= '<p>' . $article['price'] . '</p>';
//         $htmlContent .= '</div>';
//     }
// } else {
//     $error = "No articles found for the user.";
// }

// Close the statement and database connection
$stmt->close();
$conn->close();

// Output the generated HTML content
echo $htmlContent;
?>
