<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages de l'Utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <img src="logo.png" class="logo" width="150" height="120">
        <ul>
            <li><a href="admin_dashboard.php">Tableau de Bord</a></li>
            <li><a href="manage_users.php">Gérer Utilisateurs</a></li>
            <li><a href="manage_messages.php">Gérer Messages</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- User Messages Section -->
    <section class="messages">
        <div class="main">
            <?php
            // Vérifie si l'utilisateur est connecté en tant qu'administrateur
            session_start();
            if (!isset($_SESSION['admin_id'])) {
                header("Location: login.php");
                exit();
            }

            // Vérifie si un ID d'utilisateur est passé via GET
            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];

                // Connexion à la base de données
                $host = 'localhost';
                $dbname = 'meetgame';
                $username = 'root';
                $password = 'root';

                try {
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Prépare et exécute la requête de sélection
                    $sql = "SELECT m.id, m.sender_id, m.receiver_id, m.message, m.sent_at, m.signalement,
                                   u1.username AS sender_username, u1.photos AS sender_photo, 
                                   u2.username AS receiver_username, u2.photos AS receiver_photo 
                            FROM messages m
                            JOIN users u1 ON m.sender_id = u1.id
                            JOIN users u2 ON m.receiver_id = u2.id
                            WHERE m.sender_id = :user_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();

                    // Récupère les résultats
                    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Affiche le titre
                    if (count($messages) > 0) {
                        echo "<h2>Messages envoyés par l'utilisateur identifiant $user_id </h2>";
                    } else {
                        echo "<h2>Aucun message trouvé pour cet utilisateur</h2>";
                    }

                } catch (PDOException $e) {
                    die("Erreur de connexion à la base de données: " . $e->getMessage());
                }
            } else {
                // Redirige vers la page de gestion des messages si aucun ID d'utilisateur n'est passé
                header("Location: manage_messages.php");
                exit();
            }
            ?>
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
                    foreach ($messages as $message) {
                        $sender_photo = !empty($message['sender_photo']) ? $message['sender_photo'] : 'default.png';
                        $receiver_photo = !empty($message['receiver_photo']) ? $message['receiver_photo'] : 'default.png';
                        $signalement = $message['signalement'] ? 'Oui' : 'Non';
                        echo "<tr>
                                <td>{$message['id']}</td>
                                <td><img src='{$sender_photo}' alt='Photo de {$message['sender_username']}' style='border-radius: 50%; width: 100px; height: 100px;'> {$message['sender_id']} - {$message['sender_username']}</td>
                                <td><img src='{$receiver_photo}' alt='Photo de {$message['receiver_username']}' style='border-radius: 50%; width: 100px; height: 100px;'> {$message['receiver_id']} - {$message['receiver_username']}</td>
                                <td>{$message['message']}</td>
                                <td>{$message['sent_at']}</td>
                                <td>{$signalement}</td>
                                <td>
                                    <form action='delete_message.php' method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='message_id' value='{$message['id']}'>
                                        <button type='submit' class='button delete'>Supprimer</button>
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







