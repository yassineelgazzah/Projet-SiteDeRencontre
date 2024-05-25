<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifie si un ID de message est passé via POST
if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];

    // Connexion à la base de données
    $host = 'localhost';
    $dbname = 'meetgame';
    $username = 'root';
    $password = 'root';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prépare et exécute la requête de suppression
        $sql = "DELETE FROM messages WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $message_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirige vers la page de gestion des messages avec un message de succès
        header("Location: manage_messages.php?message=Message supprimé avec succès");
        exit();

    } catch (PDOException $e) {
        // Redirige vers la page de gestion des messages avec un message d'erreur
        header("Location: manage_messages.php?error=Erreur lors de la suppression du message");
        exit();
    }
} else {
    // Redirige vers la page de gestion des messages si aucun ID de message n'est passé
    header("Location: manage_messages.php");
    exit();
}
?>





