<?php

session_start();
$idU = $_SESSION['idU'];
$role = $_SESSION['Role'];


// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Retrieve form data
    $nameP = $_POST["nameP"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $category = $_POST["category"];
    $subcategory = $_POST["subcategory"];
    $url = $_POST['url'];
    
    // $url = 'Images/login.jpg'; // Use the direct path


    // Validate form data (you can add more validation as needed)
    if (empty($nameP) || empty($description) || empty($price) || empty($stock) || empty($url) || empty($category) || empty($subcategory)) {
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
         $stmt = $conn->prepare("INSERT INTO products (idC, idSC ,nameP, description, price, stock, image_url, legal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

         //get id of category
         $stmtC = $conn->prepare("SELECT idC FROM category WHERE nameC = ?");
         $stmtC->bind_param("s", $category);
         // Execute the SQL statement
         $stmtC->execute();
         $resultC = $stmtC->get_result();
         $idC = $resultC->fetch_assoc()['idC'];
         // get id of subCategory
         $stmtSC = $conn->prepare("SELECT idSC FROM subcategory WHERE nameSC = ?");
         $stmtSC->bind_param("s", $subcategory);
         // Execute the SQL statement
         $stmtSC->execute();
         $resultSC = $stmtSC->get_result();
         $idSC = $resultSC->fetch_assoc()['idSC'];

         if($role !== "user"){
            $legal = true; 
         }else{
            $legal = false; 
         }
         $types = "sssssss";
         $stmt->bind_param("ssssssss", $idC, $idSC, $nameP, $description, $price, $stock, $url, $legal);
         // Execute the SQL statement
         if ($stmt->execute()) {
             echo "Account created successfully!";
             
            // Get the last inserted idP
            $idP = $conn->insert_id;

            //stor product in myArticleS
            $stmtMyArt = $conn->prepare("INSERT INTO myarticles (idU,idP) VALUES (?, ?)");
            $stmtMyArt->bind_param("ss",$idU, $idP);
            $stmtMyArt->execute();
            $_SESSION["idU"] = $idU;
            $_SESSION["idP"] = $idP;

             // Redirect user to login page
             header("Location: ../product.html");
             exit(); // Ensure script execution stops after redirection
         } else {
             echo "Error creating account: " . $conn->error;
         }
        // Close the statement and database connection
        $stmtA->close();
        $stmtC->close();
        $stmtMyArt->close();
        $stmt->close();
        $conn->close();
    }
}
?>
