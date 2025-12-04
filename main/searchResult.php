<?php
// // Start the session
session_start(); 
$articles = $_SESSION["resultSearch"];
        
header('Content-Type: application/json');
echo json_encode($articles);


?>