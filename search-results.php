<?php
session_start();

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
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

// Récupérer les paramètres de recherche
$pseudonyme = isset($_GET['pseudonyme']) ? $_GET['pseudonyme'] : '';
$sexe = isset($_GET['sexe']) ? $_GET['sexe'] : '';
$age_min = isset($_GET['age_min']) ? $_GET['age_min'] : '';
$age_max = isset($_GET['age_max']) ? $_GET['age_max'] : '';
$lieu_residence = isset($_GET['lieu_residence']) ? $_GET['lieu_residence'] : '';
$centres_interet = isset($_GET['centres_interet']) ? $_GET['centres_interet'] : '';

// Construire la requête SQL en fonction des paramètres de recherche
$sql = "SELECT * FROM users WHERE id != ?";
$params = [$currentUserId];

if (!empty($pseudonyme)) {
    $sql .= " AND username LIKE ?";
    $params[] = "%$pseudonyme%";
}
if (!empty($sexe)) {
    $sql .= " AND gender = ?";
    $params[] = $sexe;
}
if (!empty($age_min)) {
    $sql .= " AND YEAR(CURRENT_DATE) - YEAR(birthdate) >= ?";
    $params[] = $age_min;
}
if (!empty($age_max)) {
    $sql .= " AND YEAR(CURRENT_DATE) - YEAR(birthdate) <= ?";
    $params[] = $age_max;
}
if (!empty($lieu_residence)) {
    $sql .= " AND residence LIKE ?";
    $params[] = "%$lieu_residence%";
}
if (!empty($centres_interet)) {
    $sql .= " AND personal_info LIKE ?";
    $params[] = "%$centres_interet%";
}

// Préparer et exécuter la requête SQL
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la Recherche</title>
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

    <!-- Hero Section -->
    <div class="hero">
        <div class="content">
            <h1>Résultats de la <span>Recherche</span></h1>
        </div>
    </div>

    <!-- Search Results Section -->
    <br><br>
    <section class="search-results">
        <div class="main">
            <?php if (count($users) > 0): ?>
                <ul class="user-list">
                    <?php foreach ($users as $user): ?>
                        <li class="user-item">
                            <div class="user-info">
                                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                                <p>Sexe: <?php echo htmlspecialchars($user['gender']); ?></p>
                                <p>Date de naissance: <?php echo htmlspecialchars($user['birthdate']); ?></p>
                                <p>Profession: <?php echo htmlspecialchars($user['profession']); ?></p>
                                <p>Lieu de résidence: <?php echo htmlspecialchars($user['residence']); ?></p>
                                <p>Statut relationnel: <?php echo htmlspecialchars($user['relationship_status']); ?></p>
                                <p>Description physique: <?php echo htmlspecialchars($user['physical_description']); ?></p>
                                <p>Message d'accueil: <?php echo htmlspecialchars($user['personal_info']); ?></p>
                            </div>
                            <?php if (!empty($user['photos'])): ?>
                                <?php $photos = explode(',', $user['photos']); ?>
                                <div class="profile-img">
                                <?php echo "<img src='" . $user['photos'] . "' alt='Photo de profil' >"; ?>
                                </div>
                            <?php endif; ?>
                            <div class="view-profile-btn">
                                <a href="view-profile.php?user_id=<?php echo $user['id']; ?>" class="btn">Voir Profil</a>
                            </div><br><br>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun résultat trouvé.</p
            <?php endif; ?>
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
