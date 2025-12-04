<?php
// Start the session
session_start();
$idU = $_SESSION['idU'];
$role = $_SESSION['Role'];
$showProductID = $_SESSION["showProductID"];
header('Content-Type: application/json');
echo json_encode($role);

?>