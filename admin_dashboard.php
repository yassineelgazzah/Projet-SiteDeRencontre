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

    // Requête pour compter le nombre total d'utilisateurs
    $sql_total_users = "SELECT COUNT(*) AS total_users FROM users";
    $stmt_total_users = $pdo->query($sql_total_users);
    $total_users = $stmt_total_users->fetchColumn();


    // Requête pour compter le nombre total de messages
    $sql_total_messages = "SELECT COUNT(*) AS total_messages FROM messages";
    $stmt_total_messages = $pdo->query($sql_total_messages);
    $total_messages = $stmt_total_messages->fetchColumn();

    // Requête pour compter le nombre d'abonnements actifs (différents de "aucun")
    $sql_active_subscriptions = "SELECT COUNT(*) AS active_subscriptions FROM users WHERE abonnement != 'aucun'";
    $stmt_active_subscriptions = $pdo->query($sql_active_subscriptions);
    $active_subscriptions = $stmt_active_subscriptions->fetchColumn();

    // Requête pour obtenir la date de la première inscription
    $sql_first_signup = "SELECT MIN(created_at) AS first_signup FROM users";
    $stmt_first_signup = $pdo->query($sql_first_signup);
    $first_signup = $stmt_first_signup->fetchColumn();

    // Requête pour obtenir l'âge moyen des utilisateurs
    $sql_avg_age = "SELECT AVG(YEAR(CURDATE()) - YEAR(birthdate)) AS avg_age FROM users";
    $stmt_avg_age = $pdo->query($sql_avg_age);
    $avg_age = $stmt_avg_age->fetchColumn();

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
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
            <li><a href="manage_users.php">Gérer Utilisateurs</a></li>
            <li><a href="manage_messages.php">Gérer Messages</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content">
            <h1>Tableau de Bord Administrateur</h1>
        </div>
    </div>

    <!-- Admin Dashboard Section -->
    <section class="admin-dashboard">
        <div class="main">
            <div class="admin-options">
                <h2>Options d'Administration</h2>
                <ul>
                    <li><a href="manage_users.php">Gérer Utilisateurs</a></li> 
                    <li><a href="manage_messages.php">Gérer Messages</a></li>
                    
                </ul>
            </div>
            <div class="admin-stats">
                <h2>Statistiques</h2>
                <p>Nombre total d'utilisateurs: <strong><?php echo $total_users; ?></strong></p>
                <p>Nombre total de messages: <strong><?php echo $total_messages; ?></strong></p>
                <p>Abonnements actifs: <strong><?php echo $active_subscriptions; ?></strong></p>
                <p>Âge moyen des utilisateurs: <strong><?php echo round($avg_age, 1), ' ans'; ?></strong></p>
                <p>Date de la première inscription: <strong><?php echo date('d/m/Y', strtotime($first_signup)); ?></strong></p>            </div>
        </div>
    </section>

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

    
