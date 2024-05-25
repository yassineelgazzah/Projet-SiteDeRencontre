<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $abonnement = htmlspecialchars($_POST['abonnement']);

    // Mettre à jour l'abonnement de l'utilisateur
    $stmt = $pdo->prepare("UPDATE users SET abonnement = ? WHERE id = ?");
    $stmt->execute([$abonnement, $user_id]);

    // Rediriger vers la page des abonnements après la mise à jour
    header("Location: dashboard.php");
    exit();
}
?>
