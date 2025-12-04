<?php

if (isset($_POST['legality'])) {

    
    // Now you can use $legality in your code
    $legality = $_POST['legality'];

    // Use the value of 'legality' as needed
    echo "The selected legality is: " . $legality;

    session_start();



    $legality = $_POST['legality'];

    // Store idP_show value in a session variable
    $_SESSION["legality"] = $legality;
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
    $stmt = $conn->prepare("Update products SET legal = ?  where idP = ?");
    $stmt->bind_param("ss", $legality , $showProductID);
    // Execute the SQL statement
    $stmt->execute();  

} else {
    // If legality value is not sent through POST, handle the error
    echo "Error: Legality value not received";
}


// session_start();


// $legality = $_GET['legality'];

// // Store idP_show value in a session variable
// $_SESSION["legality"] = $legality;
// $idU = $_SESSION['idU'];
// $role = $_SESSION['Role'];
// $showProductID = $_SESSION["showProductID"];
// $servername = "localhost";
// $dbUsername = "root";
// $dbPassword = "";
// $dbName = "db_shop";


// $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// // Prepare and bind the SQL statement
// $stmt = $conn->prepare("Update products SET legal = ?");
// $stmt->bind_param("s", $legality);
// // Execute the SQL statement
// $stmt->execute();  

// // echo $legality;

// // Redirect to showProduct.html
// // header('Location: showProduct.html');
// exit; // Make sure to exit after the redirect


?>