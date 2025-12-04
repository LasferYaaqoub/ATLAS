<?php
// Start the session
session_start();
// Retrieve the value sent from JavaScript
// $idP = $_POST['idP'];

// Process the value (e.g., save it to a database, perform calculations, etc.)
// For demonstration, simply echo the value back
// echo "Received value: " . $idP;

// Retrieve user ID from session
$idU = $_SESSION['idU'];
$idP = $_SESSION['editProductID'];


// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Retrieve form data
    $nameP = $_POST["nameP"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $url = $_POST['url'];
    // Validate form data (you can add more validation as needed)
    if (empty($nameP) || empty($description) || empty($price) || empty($stock) || empty($url)) {
        $error = "all fields are required.";
    } else {
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
        $stmt = $conn->prepare("Update products SET nameP = ?, description =?, price = ?, stock=?, image_url=? where idP = ?");
        $stmt->bind_param("sssssi", $nameP, $description, $price, $stock, $url ,$idP);
        // Execute the SQL statement
        if ($stmt->execute()) {
            echo "updated successfully!";
            
             // Get the last inserted idP

             // Redirect user to login page
            header("Location: ../product.html");
            exit(); // Ensure script execution stops after redirection
        } else {
            echo "Error creating account: " . $conn->error;
        }
       // Close the statement and database connection
      
       $stmt->close();
       $conn->close();
   }
}
?>