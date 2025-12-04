<?php
if (isset($_POST["submit"])) {
    // Retrieve form data
    $searchInput = $_POST["searchInput"];
    $minPrice = $_POST["minPrice"];
    $maxPrice = $_POST["maxPrice"];
    $category = $_POST["category"];
    echo ($searchInput);
    echo ($maxPrice);
    echo ($minPrice);
    echo ($category);
    session_start();
    


    // Validate form data (you can add more validation as needed)
    if (empty($searchInput) && empty($maxPrice) && empty($minPrice) && empty($category)) {
        echo "All fields are required.";
    } else if(!empty($searchInput) && empty($minPrice) && empty($maxPrice) && ($category==0) ){
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
        $stmt = $conn->prepare("SELECT * FROM products WHERE legal = 1 AND nameP LIKE ?");
        $searchInput = '%' . $searchInput . '%';
        $stmt->bind_param("s", $searchInput);

        
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch products and output as JSON
        $articles = array();
        if ($result->num_rows > 0) {
            while ($article = $result->fetch_assoc()) {
                $articles[] = $article;
            }
            // header('Content-Type: application/json');
            // echo json_encode($articles);
        }
        $_SESSION["resultSearch"]= $articles;
        
        header("Location: search.html");
        // exit(); // Make sure to exit after the redirect

        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    // }
}else if(!empty($searchInput) && !empty($minPrice) && !empty($maxPrice) && $category <> 0){
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
    $stmt = $conn->prepare("SELECT * FROM products WHERE legal = 1 AND nameP LIKE ? AND price BETWEEN ? AND ? AND idC = ?");
    $searchInput = '%' . $searchInput . '%';
    $stmt->bind_param("siii", $searchInput, $minPrice, $maxPrice, $category);



    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch products and output as JSON
    $articles = array();
    if ($result->num_rows > 0) {
        while ($article = $result->fetch_assoc()) {
            $articles[] = $article;
        }
        // header('Content-Type: application/json');
        // echo json_encode($articles);
    }
    $_SESSION["resultSearch"]= $articles;

    header("Location: search.html");
    // exit(); // Make sure to exit after the redirect

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}else if(empty($searchInput) && !empty($minPrice) && !empty($maxPrice) && $category <> 0){
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
    $stmt = $conn->prepare("SELECT * FROM products WHERE legal = 1  AND price BETWEEN ? AND ? AND idC = ?");
    
    $stmt->bind_param("sii", $minPrice, $maxPrice, $category);



    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch products and output as JSON
    $articles = array();
    if ($result->num_rows > 0) {
        while ($article = $result->fetch_assoc()) {
            $articles[] = $article;
        }
        // header('Content-Type: application/json');
        // echo json_encode($articles);
    }
    $_SESSION["resultSearch"]= $articles;

    header("Location: search.html");
    // exit(); // Make sure to exit after the redirect

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
}else{
    echo "error";
}
?>
