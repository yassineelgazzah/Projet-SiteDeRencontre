<?php
// Initialiser la session
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil (index.html)
header("Location: index.html");
exit();
?>

