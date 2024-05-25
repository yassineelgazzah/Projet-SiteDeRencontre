<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
session_start();
if (!isset($_SESSION['admin_id'])) {
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Messages</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;300;400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous">
    <link rel="icon" href="logoAegMongaeSur.jpg" type="image/x-icon">
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <img src="logo.png" class="logo" width="150" height="120">
        <ul>
            <li><a href="admin_dashboard.php">Tableau de Bord</a></li>
            <li><a href="manage_users.php">Gérer Utilisateurs</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content">
            <h1>Gérer les Messages</h1>
        </div>
    </div>

    <!-- Messages Section -->
    <section class="messages">
        <div class="main">
            <h2>Messages des Utilisateurs</h2>
        </div>
        <div class="main">
            <table>
                <thead>
                    <tr>
                        <th>ID Message</th>
                        <th>De (Photo - ID - Pseudo)</th>
                        <th>À (Photo - ID - Pseudo)</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Signalé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT m.id, m.sender_id, m.receiver_id, m.message, m.sent_at, m.signalement,
                                   u1.username AS sender_username, u1.photos AS sender_photo, 
                                   u2.username AS receiver_username, u2.photos AS receiver_photo 
                            FROM messages m
                            JOIN users u1 ON m.sender_id = u1.id
                            JOIN users u2 ON m.receiver_id = u2.id";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $sender_photo = !empty($row['sender_photo']) ? $row['sender_photo'] : 'default.png';
                        $receiver_photo = !empty($row['receiver_photo']) ? $row['receiver_photo'] : 'default.png';
                        $signalement = $row['signalement'] ? 'Oui' : 'Non';
                        
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td><img src='{$sender_photo}' alt='Photo de {$row['sender_username']}' style='border-radius: 50%; width: 100px; height: 100px;'> {$row['sender_id']} - {$row['sender_username']}</td>
                                <td><img src='{$receiver_photo}' alt='Photo de {$row['receiver_username']}' style='border-radius: 50%; width: 100px; height: 100px;'> {$row['receiver_id']} - {$row['receiver_username']}</td>
                                <td>{$row['message']}</td>
                                <td>{$row['sent_at']}</td>
                                <td>{$signalement}</td>
                                <td>
                                    <form action='delete_message.php' method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='message_id' value='{$row['id']}'>
                                        <button type='submit' class='button delete'>Supprimer</button>
                                    </form>
                                    <form action='view_user_messages.php' method='GET' style='display:inline-block;'>
                                        <input type='hidden' name='user_id' value='{$row['sender_id']}'>
                                        <button type='submit' class='button view'>Voir Messages de l'Utilisateur</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>MeetGame</p>
        <div class="social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
        <p class="end">© Tous droits réservés</p>
    </footer>
</body>
</html>









