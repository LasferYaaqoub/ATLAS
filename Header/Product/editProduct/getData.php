<?php
// Retrieve the value sent from JavaScript
$idP = $_POST['idP'];

// Process the value (e.g., save it to a database, perform calculations, etc.)
// For demonstration, simply echo the value back
echo "Received value: " . $idP;

session_start();
$_SESSION["editProductID"] = $idP;

?>