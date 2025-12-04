<?php
session_start();
$idU = $_SESSION['idU'];
$role = $_SESSION["Role"];
$idPL = $_SESSION["showProductID"];

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
$stmtCheckedLike = $conn->prepare("SELECT * FROM favourite where idU = ? and idP = ?");
$stmtCheckedLike->bind_param("ss",$idU , $idPL);
$stmtCheckedLike->execute();
$resultCheckedLike = $stmtCheckedLike->get_result();

// Check if the favourite product exists
if ($resultCheckedLike->num_rows >= 1) {
    // delete favourite product
    $stmtDeleteLike = $conn->prepare("DELETE FROM favourite where idU = ? and idP = ?");
    $stmtDeleteLike->bind_param("ss",$idU , $idPL);
    $stmtDeleteLike->execute();

} else {
    // add favourite product
    $stmtAddLike = $conn->prepare("INSERT INTO favourite  (idU ,idP) values (? ,?)");
    $stmtAddLike->bind_param("ss",$idU , $idPL);
    $stmtAddLike->execute();    
} 



?>