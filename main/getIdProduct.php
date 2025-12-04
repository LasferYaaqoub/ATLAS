<?php
session_start();

// Retrieve the value of idP_show from the URL parameter
$idP_show = $_GET['idP_show'];

// Store idP_show value in a session variable
$_SESSION["showProductID"] = $idP_show;

// Redirect to showProduct.html
header('Location: showProduct.html');
// exit; // Make sure to exit after the redirect


?>