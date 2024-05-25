<?php
session_start();

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

// Récupérer les informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <title>Tableau de Bord</title>
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
            <li><a href="#profile">Profil</a></li>
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
            <h1>Bienvenue, <span><?php echo htmlspecialchars($user['username']); ?></span></h1>
            <p class="para">Accédez à votre profil, modifiez vos informations personnelles et découvrez vos activités récentes.</p>
        </div>
    </div>

    <!-- Profile Section -->
    <section id="profile" class="profile">
        <div class="main">
            <div class="profile-img">
            <?php echo "<img src='" . $user['photos'] . "' alt='Photo de profil' >"; ?>
            </div>
            <div class="profile-text">
                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                <p><strong>Sexe:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
                <p><strong>Date de naissance:</strong> <?php echo htmlspecialchars($user['birthdate']); ?></p>
                <p><strong>Profession:</strong> <?php echo htmlspecialchars($user['profession']); ?></p>
                <p><strong>Lieu de résidence:</strong> <?php echo htmlspecialchars($user['residence']); ?></p>
                <p><strong>Situation amoureuse:</strong> <?php echo htmlspecialchars($user['relationship_status']); ?></p>
                <a href="edit-profile.php" class="btn">Modifier</a>
            </div>
        </div>
    </section>

    <!-- Informations Section -->
    <section id="info" class="info">
        <div class="main">
            <div class="info-text">
                <h2>Informations Personnelles : </h2>
                <p><strong>Description physique :</strong> <?php echo htmlspecialchars($user['physical_description']); ?></p>
                <p><strong>Infos :</strong> <?php echo htmlspecialchars($user['personal_info']); ?></p>
                <p></p>
            </div>
        </div>
    </section>
    <section id="info" class="info">
        <div class="main">
            <div class="info-text">
                <h2>Abonnement : </h2>
                <p><?php echo htmlspecialchars($user['abonnement']); ?></p>

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
