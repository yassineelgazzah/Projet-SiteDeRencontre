<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['message_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID de message manquant.']);
    exit();
}

$messageId = $data['message_id'];
$userId = $_SESSION['user_id'];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=meetgame", 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Vérifiez si le message existe
    $checkSql = "SELECT * FROM messages WHERE id = :message_id";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute(['message_id' => $messageId]);
    $message = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$message) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Message non trouvé.']);
        exit();
    }

    $sql = "UPDATE messages SET signalement = 1 WHERE id = :message_id";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(['message_id' => $messageId])) {
        echo json_encode(['success' => true, 'message' => 'Message signalé.']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Échec du signalement du message.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
}
?>










