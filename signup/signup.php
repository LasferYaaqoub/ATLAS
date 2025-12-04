<?php
// Start the session
session_start();
// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Retrieve form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];


    // Validate form data (you can add more validation as needed)
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } else {
        // Connect to MySQL database
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "db_shop";

        $conn = new mysqli($servername, $dbUsername, "", $dbName);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $nullValue = null; // For CreditCard
        $role = "user"; // For role
        $stmt->bind_param("ssss", $username, $email, $password, $role);

        // Execute the SQL statement
        if ($stmt->execute()) {
            echo "Account created successfully!";
            // Redirect user to login page
            header("Location:../login/login.html");
            exit(); // Ensure script execution stops after redirection
        } else {
            echo "Error creating account: " . $conn->error;
        }

        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    }
}{
    echo "error";
}
?>
