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

$data = json_decode(file_get_contents('php://input'), true);
$currentUserId = $_SESSION['user_id'];
$recipientId = $data['recipient_id'];
$message = $data['message'];

$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)";
$stmt = $pdo->prepare($sql);
$stmt->execute(['sender_id' => $currentUserId, 'receiver_id' => $recipientId, 'message' => $message]);

echo json_encode(['success' => true]);
?>