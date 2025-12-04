<?php
                            //login
// Start the session
session_start();

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Retrieve form data
    $username = $_POST["username"];
    $_SESSION['username'] = $username;
    $password = $_POST["password"];

    // Validate form data (you can add more validation as needed)
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
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
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);

        // Execute the SQL statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows == 1) {
            // Verify the password
            $row = $result->fetch_assoc();
            if (($password == $row["password"])) {
                // Password is correct, set session variables


                $role = $row["Role"];
                $idU = $row['idU'];
                $_SESSION["idU"] = $idU;
                $_SESSION["Role"] = $role;


                // Redirect user to dashboard or home page
                header("Location: ../main/main.html");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }

        // Close the statement and database connection
        $stmt->close();
        // $conn->close();
    }
 

}
?>
