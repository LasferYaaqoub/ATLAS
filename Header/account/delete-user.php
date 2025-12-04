<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is provided in the request body
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->username)) {
        // Assuming you have a database connection
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "db_shop";

        // Create connection
        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // select idU of the target user for deletion
        $stmtDeleteIdU = $conn->prepare("SELECT idU FROM users WHERE username = ?");
        $stmtDeleteIdU->bind_param("s", $data->username);
        $stmtDeleteIdU->execute();
        $resultDeleteIdU = $stmtDeleteIdU->get_result();
        $DeleteIdU = $resultDeleteIdU->fetch_assoc();

        // delete favourite products of user
        $favouriteP = $conn->prepare("DELETE FROM favourite WHERE idU = ?");
        $favouriteP->bind_param("i", $DeleteIdU['idU']);
        $favouriteP->execute();

        // delete products of user
        $stmtIdProduct = $conn->prepare("SELECT idP FROM myarticles WHERE idU = ?");
        $stmtIdProduct->bind_param("i", $DeleteIdU['idU']);
        $stmtIdProduct->execute();
        $resultIdProduct = $stmtIdProduct->get_result();
        $idProducts = array();

        // Check if idProducts are found for the user
        if ($resultIdProduct->num_rows > 0) {
            // Loop through the result set and add article data to the array
            while ($idProduct = $resultIdProduct->fetch_assoc()) {
                $idProducts[] = $idProduct['idP']; // Extracting 'idP' from the result
            }
        }

        

        // Check if there are any products to delete
        if (!empty($idProducts)) {
            // Convert array of product IDs into comma-separated string
            $idProductsString = implode(',', $idProducts);

            $myarticlesP = $conn->prepare("DELETE FROM myarticles WHERE idU = ?");
            $myarticlesP->bind_param("i", $DeleteIdU['idU']);
            $myarticlesP->execute();


            // Prepare a statement to delete products that do not belong to any article of the user
            $product = $conn->prepare("DELETE FROM products WHERE idP IN ($idProductsString)");
            $product->execute();
        }
            $myarticlesP = $conn->prepare("DELETE FROM myarticles WHERE idU = ?");
            $myarticlesP->bind_param("i", $DeleteIdU['idU']);
            $myarticlesP->execute();

        

        // delete user
        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $data->username);

        // Execute the statement
        if ($stmt->execute()) {
            // Deletion successful
            echo json_encode(array("message" => "User '{$data->username}' deleted successfully"));
        } else {
            // Deletion failed
            echo json_encode(array("error" => "Error deleting user"));
        }

        // Close statements and connection
        $stmtDeleteIdU->close();
        $stmt->close();
        $conn->close();
    } else {
        // Username not provided in the request body
        echo json_encode(array("error" => "Username not provided"));
    }
} else {
    // Invalid request method
    echo json_encode(array("error" => "Invalid request method"));
}









?>