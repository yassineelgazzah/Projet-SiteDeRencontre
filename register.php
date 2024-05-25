<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $gender = htmlspecialchars($_POST['gender']);
    $birthdate = htmlspecialchars($_POST['birthdate']);
    $profession = htmlspecialchars($_POST['profession']);
    $residence = htmlspecialchars($_POST['residence']);
    $relationshipStatus = htmlspecialchars($_POST['relationship-status']);
    $physicalDescription = htmlspecialchars($_POST['physical-description']);
    $personalInfo = htmlspecialchars($_POST['personal-info']);
    $abonnement = 'aucun'; // Valeur par défaut

    // Vérification des mots de passe
    if ($password !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérification de l'unicité de l'email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Traitement des photos téléchargées
        $photoPaths = [];
        if (!empty($_FILES['photos']['name'][0])) {
            $tmpFilePath = $_FILES['photos']['tmp_name'][0]; // Obtenir le chemin du premier fichier seulement
            if ($tmpFilePath != "") {
                // Génération d'un nom unique pour l'image
                $fileName = uniqid() . '-' . $_FILES['photos']['name'][0];
                $newFilePath = "uploads/" . $fileName;
                // Déplacement de l'image téléchargée vers le dossier des téléchargements
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $photoPaths[] = $newFilePath; // Ajout du chemin de l'image à la liste
                }
            }
        }

            // Insertion dans la base de données
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, gender, birthdate, profession, residence, relationship_status, physical_description, personal_info, photos, abonnement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword, $gender, $birthdate, $profession, $residence, $relationshipStatus, $physicalDescription, $personalInfo, implode(',', $photoPaths), $abonnement])) {
                $success = "Inscription réussie!";
            } else {
                $error = "Une erreur est survenue lors de l'inscription.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | MeetGame</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="icon" href="logoAegMongaeSur.jpg" type="image/x-icon">
</head>
<body>
    <div class="hero">
        <nav>
            <img src="logo.png" class="logo" width="150" height="120">
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="login.php">Connexion</a></li>
            </ul>
        </nav>
        
        <div class="register-container">
            <h1>Inscription</h1>
            <?php
            if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            } elseif (isset($success)) {
                echo "<p style='color: green;'>$success</p>";
            }
            ?>
            <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="confirm-password">Confirmez le mot de passe</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <div class="input-group">
                    <label for="gender">Sexe</label>
                    <select id="gender" name="gender" required>
                        <option value="male">Homme</option>
                        <option value="female">Femme</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="birthdate">Date de naissance</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
                <div class="input-group">
                    <label for="profession">Profession</label>
                    <input type="text" id="profession" name="profession">
                </div>
                <div class="input-group">
                    <label for="residence">Lieu de résidence</label>
                    <input type="text" id="residence" name="residence" placeholder="Pays, Région, Département, Ville">
                </div>
                <div class="input-group">
                    <label for="relationship-status">Situation amoureuse et familiale</label>
                    <input type="text" id="relationship-status" name="relationship-status">
                </div>
                <div class="input-group">
                    <label for="physical-description">Description physique</label>
                    <textarea id="physical-description" name="physical-description" rows="3" placeholder="Taille, Poids, Couleur des yeux, Cheveux"></textarea>
                </div>
                <div class="input-group">
                    <label for="personal-info">Informations personnelles</label>
                    <textarea id="personal-info" name="personal-info" rows="4" placeholder="Message d'accueil, Citation, Traits de caractère, Centres d'intérêt, Fumeur ou non"></textarea>
                </div>
                <div class="input-group">
                    <label for="photos">Photos</label>
                    <input type="file" id="photos" name="photos[]" accept="image/*" required single>
                </div>
                <button type="submit" class="btn">S'inscrire</button>
                <p class="login-link">Déjà un compte ? <a href="login.php">Connectez-vous ici</a></p>
            </form>
        </div>
    </div>
    
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
