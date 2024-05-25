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

// Récupérer l'ID de l'utilisateur actuellement connecté
$currentUserId = $_SESSION['user_id'];

// Récupérer tous les profils de la base de données, en excluant le profil de l'utilisateur actuel
$stmt = $pdo->prepare("SELECT * FROM users WHERE id != ?");
$stmt->execute([$currentUserId]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Profils</title>
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
            <li><a href="dashboard.php">Tableau de Bord</a></li>
            <li><a href="search.php">Recherche</a></li>
            <li><a href="messaging.php">Messagerie</a></li>
            <li><a href="subscription.php">Abonnements</a></li>
            <li><a href="terms_of_service.php">Conditions d'Utilisation</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content">
            <h1>Liste des <span>Profils</span></h1>
        </div>
    </div>

    <!-- Profiles Section -->
    <section class="profiles">
        <div class="main">
            <ul class="profile-list">
                <?php foreach ($users as $user): ?>
                    <br><br>
                    <li class="profile-item">
                        <h2><?= htmlspecialchars($user['username']) ?></h2>
                        <p>Sexe: <?= htmlspecialchars($user['gender']) ?></p>
                        <p>Date de naissance: <?= htmlspecialchars($user['birthdate']) ?></p>
                        <div class="profile-img">
                        <?php echo "<img src='" . $user['photos'] . "' alt='Photo de profil' >"; ?>
                        </div>
                        <!-- Ajoutez d'autres informations de profil à afficher ici -->
                        <div class="view-profile-btn">
                            <a href="view-profile.php?user_id=<?php echo $user['id']; ?>" class="btn">Voir Profil</a>
                        </div><br><br>
                    </li>
                    <br><br>
                <?php endforeach; ?>
            </ul>
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
