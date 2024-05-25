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
    <title>Conditions d'Utilisation</title>
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
            <li><a href="contact.php">Contact</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content">
            <h1>Conditions d'Utilisation</h1>
        </div>
    </div>

    <!-- Terms of Service Section -->
    <section class="terms">
            <div class="main">
            <h2>Bienvenue sur notre site</h2>
            </div>
            <div class="main">
            <p>En utilisant notre site, vous acceptez de respecter et d'être lié par les conditions d'utilisation suivantes. Veuillez les lire attentivement.</p>
            </div>

            <div class="main">
            <h3>1. Acceptation des Conditions</h3>
            </div> 
            <div class="main">
            <p>En accédant à ce site, vous acceptez d'être lié par ces conditions d'utilisation, toutes les lois et réglementations applicables, et acceptez que vous êtes responsable du respect des lois locales en vigueur.</p>
            </div>

            <div class="main">
            <h3>2. Utilisation du Site</h3>
            </div> 
            <div class="main">
            <p>Vous acceptez d'utiliser ce site uniquement à des fins légales et de manière à ne pas porter atteinte aux droits de, ou restreindre ou empêcher l'utilisation et la jouissance de ce site par un tiers.</p>
            </div>

            <div class="main">
            <h3>3. Propriété Intellectuelle</h3>
            </div> 
            <div class="main">
            <p>Tout le contenu de ce site, y compris mais sans s'y limiter, les textes, graphiques, images, et tout autre matériel, est protégé par des droits d'auteur et ne peut être utilisé sans autorisation préalable écrite de notre part.</p>
            </div>

            <div class="main">
            <h3>4. Limitation de Responsabilité</h3>
            </div> 
            <div class="main">
            <p>En aucune circonstance, nous ne serons responsables des dommages directs, indirects, accessoires, spéciaux ou consécutifs qui résultent de l'utilisation ou de l'impossibilité d'utiliser ce site.</p>
            </div>

            <div class="main">
            <h3>5. Modifications des Conditions</h3>
            </div> 
            <div class="main">
            <p>Nous nous réservons le droit de modifier ces conditions d'utilisation à tout moment. Votre utilisation continue du site après toute modification signifie que vous acceptez ces nouvelles conditions.</p>
            </div>

            <div class="main">
            <h3>6. Contact</h3>
            </div> 
            <div class="main">
            <p>Si vous avez des questions concernant ces conditions d'utilisation, veuillez nous contacter à <a href="mailto:support@meetgame.com">support@meetgame.com</a>.</p>
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
