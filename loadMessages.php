<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit();
}

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

$userId = $_GET['user_id'];
$currentUserId = $_SESSION['user_id'];

$sql = "SELECT sender_id, message FROM messages WHERE (sender_id = :current_user_id AND receiver_id = :user_id) OR (sender_id = :user_id AND receiver_id = :current_user_id) ORDER BY sent_at ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['current_user_id' => $currentUserId, 'user_id' => $userId]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($messages);
?>

