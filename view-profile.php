<?php
session_start();

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si l'ID de l'utilisateur à afficher est spécifié dans l'URL
if (!isset($_GET['user_id'])) {
    header("Location: search.php");
    exit();
}

// Récupérer l'ID de l'utilisateur à afficher
$user_id = $_GET['user_id'];

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

// Récupérer les informations de l'utilisateur à afficher
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur existe
if (!$user) {
    echo "Utilisateur non trouvé.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?php echo htmlspecialchars($user['username']); ?></title>
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
            <li><a href="home.php">Page D'Accueil</a></li>
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

    <!-- Profile Section -->
    <section class="profile">
        <div class="main">
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user['username']); ?></h1>
                <p>Sexe: <?php echo htmlspecialchars($user['gender']); ?></p>
                <p>Date de naissance: <?php echo htmlspecialchars($user['birthdate']); ?></p>
                <p>Profession: <?php echo htmlspecialchars($user['profession']); ?></p>
                <p>Lieu de résidence: <?php echo htmlspecialchars($user['residence']); ?></p>
                <p>Statut relationnel: <?php echo htmlspecialchars($user['relationship_status']); ?></p>
                <p>Description physique: <?php echo htmlspecialchars($user['physical_description']); ?></p>
                <p>Message d'accueil: <?php echo htmlspecialchars($user['personal_info']); ?></p>
            </div>
            <div class="profile-img">
            <?php if (!empty($user['photos'])): ?>
                <?php $photos = explode(',', $user['photos']); ?>
                <?php echo "<img src='" . $user['photos'] . "' alt='Photo de profil' >"; ?>
                <?php endif; ?>
            </div>
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
