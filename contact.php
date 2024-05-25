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
    <title>Contact</title>
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
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content">
            <h1>Contactez-nous</h1>
        </div>
    </div>

    <!-- Contact Form Section -->
    <section class="contact">
        <div class="main">
        <h2>Nous Contacter</h2>
        </div>
        <div class="main">
            <p>Si vous avez des questions, des préoccupations ou des suggestions, n'hésitez pas à nous contacter en utilisant le formulaire ci-dessous.</p>
        </div>
        <div>    
            <form action="send_message.php" method="post">
                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="subject">Sujet:</label>
                <input type="text" id="subject" name="subject" required>
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="6" required></textarea>
                
                <button type="submit">Envoyer</button>
            </form>
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




