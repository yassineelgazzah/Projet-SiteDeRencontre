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

// Récupérer tous les profils de la base de données, en excluant le profil de l'utilisateur actuel
$stmt = $pdo->prepare("SELECT * FROM users WHERE id != ?");
$stmt->execute([$_SESSION['admin_id']]); // Exécute la requête avec l'id de l'admin connecté
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Utilisateurs</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;300;400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous">
    <link rel="icon" href="logoAegMongaeSur.jpg" type="image/x-icon">
</head>
<body>
    <div class="hero">
        <nav>
            <img src="logo.png" class="logo" width="150" height="120">
            <ul>
                <li><a href="admin_dashboard.php">Tableau de Bord</a></li>
                <li><a href="manage_messages.php">Gérer Messages</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
        
        <div class="hero">
            <div class="content">
                <h1>Liste des <span>Utilisateurs</span></h1>
            </div>
        </div>

        <!-- Profiles Section -->
        <section class="messages">
        <section class="profiles">
        <div class="main">
            <h2>Liste des Utilisateurs</h2>
        </div>
            <div class="main">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pseudo</th>
                            <th>Sexe</th>
                            <th>Date de naissance</th>
                            <th>Situation</th>
                            <th>Résidence</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($users) > 0): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                <th><?= htmlspecialchars($user['id']) ?></th>
                                <th><?= htmlspecialchars($user['username']) ?></th>
                                <th><?= htmlspecialchars($user['gender']) ?></th>
                                <th><?= htmlspecialchars($user['birthdate']) ?></th>
                                <th><?= htmlspecialchars($user['relationship_status']) ?></th>
                                <th><?= htmlspecialchars($user['residence']) ?></th>
                                <th><div class="profile-img">
                                        <?php echo "<img src='" . $user['photos'] . "' alt='Photo de profil' >"; ?>
                                        </div>
                                        </th>
                                        <th>
                                        <div class="view-profile-btn">
                                            <a href="edit_user.php?user_id=<?= htmlspecialchars($user['id']) ?>" class="btn">Voir Utilisateur</a>
                                        </div>
                                        <br>
                                        <div >
                                            <a class="button delete" href="delete_user.php?user_id=<?= htmlspecialchars($user['id']) ?>" class="btn">Supprimer Utilisateur</a>
                                        </div>
                                        </th>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3">Aucun utilisateur trouvé</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        </section>

        <footer>
            <p>MeetGame</p>
            <div class="social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p class="end">© Tous droits réservés</p>
        </footer>
    </div>
</body>
</html>
