<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres d'Abonnement</title>
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
            <li><a href="terms_of_service.php">Conditions d'Utilisation</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content">
            <h1>Nos Offres <span>d'Abonnement</span></h1>
        </div>
    </div>

    <!-- Subscription Section -->
    <section class="subscriptions">
        <div class="main">
            <div class="subscription-card">
                <h2>Basic</h2>
                <p>Accès limité aux fonctionnalités</p>
                <p>5€ par mois</p>
                <form action="update_subscription.php" method="POST">
                    <input type="hidden" name="abonnement" value="basic">
                    <button type="submit" class="btn">Choisir</button>
                </form>
            </div>
            <div class="subscription-card">
                <h2>Standard</h2>
                <p>Accès complet aux fonctionnalités</p>
                <p>10€ par mois</p>
                <form action="update_subscription.php" method="POST">
                    <input type="hidden" name="abonnement" value="standard">
                    <button type="submit" class="btn">Choisir</button>
                </form>
            </div>
            <div class="subscription-card">
                <h2>Premium</h2>
                <p>Accès complet + fonctionnalités premium</p>
                <p>20€ par mois</p>
                <form action="update_subscription.php" method="POST">
                    <input type="hidden" name="abonnement" value="premium">
                    <button type="submit" class="btn">Choisir</button>
                </form>
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

