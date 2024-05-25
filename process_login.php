<?php
session_start();

// Connexion à la base de données
$host = 'localhost';
$dbname = 'meetgame';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Récupérer les données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];

// Vérification dans la table des administrateurs
$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($password, $admin['password'])) {
    // Authentification réussie pour l'administrateur
    $_SESSION['admin_id'] = $admin['id'];
    header("Location: admin_dashboard.php");
    exit();
}

// Vérification dans la table des utilisateurs
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Authentification réussie pour l'utilisateur
    $_SESSION['user_id'] = $user['id'];
    header("Location: dashboard.php");
    exit();
}

// Si les identifiants ne correspondent à aucun utilisateur ni administrateur
$_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect.";
header("Location: login.php");
exit();
?>
