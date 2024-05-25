<?php
// Démarre la session
session_start();

// Vérifie si l'utilisateur est connecté en vérifiant l'existence de la variable de session 'user_id'
if (!isset($_SESSION['user_id'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit(); // Arrête l'exécution du script après la redirection
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
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
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content">
            <h1>FAQ</h1>
        </div>
    </div>

    <!-- FAQ Section -->
    <section class="faq">
        <div class="main">
            <h2>Foire Aux Questions</h2>
        </div>
            <div class="main">
                <h3>Comment puis-je m'inscrire ?</h3>
                </div>
                <div class="main">
                <p>Vous pouvez vous inscrire en cliquant sur le bouton "Inscription" en haut à droite de la page d'accueil, puis en remplissant le formulaire d'inscription.</p>
            </div>
            <div class="main">
                <h3>Comment puis-je modifier mon profil ?</h3>
                </div>
                <div class="main">
                <p>Pour modifier votre profil, connectez-vous, puis accédez à la section "Profil" et cliquez sur le bouton "Modifier" à côté des informations que vous souhaitez changer.</p>
            </div>
            <div class="main">
                <h3>Comment puis-je trouver d'autres joueurs ?</h3>
                </div>
                <div class="main">
                <p>Utilisez la fonction de recherche disponible dans la section "Recherche" pour trouver d'autres joueurs en fonction de différents critères tels que les jeux préférés, la plateforme de jeu, etc.</p>
            </div>
            <div class="main">
                <h3>Quels sont les types d'abonnements disponibles ?</h3>
                </div>
                <div class="main">
                <p>Nous offrons différents types d'abonnements avec divers avantages. Pour plus d'informations, consultez la section "Abonnements" de notre site.</p>
            </div>
            <div class="main">
                <h3>Comment puis-je contacter le support ?</h3>
                </div>
                <div class="main">
                <p>Si vous avez besoin d'aide, vous pouvez nous contacter via la page "Contact". Remplissez le formulaire et nous vous répondrons dans les plus brefs délais.</p>
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
