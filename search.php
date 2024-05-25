<?php
session_start();

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Membres</title>
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
            <h1>Recherche de <span>Membres</span></h1>
            <p class="para">Trouvez des partenaires de jeu et de nouvelles connaissances.</p>
        </div>
    </div>

    <!-- Search Section -->
    <section class="search">
        <div class="main">
            <form action="search-results.php" method="get">
                <label for="pseudonyme">Pseudonyme</label>
                <input type="text" id="pseudonyme" name="pseudonyme">

                <label for="sexe">Sexe</label>
                <select id="sexe" name="sexe">
                    <option value="">Tous</option>
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                    <option value="other">Autre</option>
                </select>

                <label for="age_min">Âge minimum</label>
                <input type="number" id="age_min" name="age_min" min="18">

                <label for="age_max">Âge maximum</label>
                <input type="number" id="age_max" name="age_max" max="100">

                <label for="lieu_residence">Lieu de résidence</label>
                <input type="text" id="lieu_residence" name="lieu_residence">

                <label for="centres_interet">Centres d'intérêt</label>
                <input type="text" id="centres_interet" name="centres_interet">

                <button type="submit" class="btn">Rechercher</button>
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

