<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

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
    $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

    // Récupérer les informations actuelles de l'utilisateur
    $stmt_old_user = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt_old_user->execute([$user_id]);
    $old_user = $stmt_old_user->fetch(PDO::FETCH_ASSOC);

    if (!$old_user) {
        die("Utilisateur non trouvé.");
    }

    // Mettre à jour tous les champs, y compris ceux qui n'ont pas été modifiés
    $fields = ['username', 'email', 'password', 'gender', 'birthdate', 'profession', 'residence', 'relationship_status', 'physical_description', 'personal_info', 'photos', 'abonnement'];

    $query = "UPDATE users SET ";
    $params = [];
    foreach ($fields as $field) {
        // Vérifie si le champ est présent dans la requête POST et s'il a changé
        if (isset($_POST[$field]) && $_POST[$field] !== $old_user[$field]) {
            $query .= "$field=?, ";
            $params[] = htmlspecialchars($_POST[$field]);
        } else {
            // Si le champ n'a pas été modifié, conserve sa valeur actuelle
            $query .= "$field=?, ";
            $params[] = $old_user[$field];
        }
    }

    if (!empty($_FILES['photos']['name'])) {
        $fileName = $_FILES['photos']['name'];
        $tmpFilePath = $_FILES['photos']['tmp_name'];
        $newFilePath = "uploads/" . basename($fileName);
        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            $query .= "photos=?, ";
            $params[] = $newFilePath;
        }
    }

    if (!empty($params)) {
        $query = rtrim($query, ', ');
        $query .= " WHERE id=?";
        $params[] = $user_id;

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
    }

    header("Location: manage_users.php");
    exit();
}

$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;300;400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous">
    <link rel="icon" href="logoAegMongaeSur.jpg" type="image/x-icon">
</head>

<body>
    <nav>
        <img src="logo.png" class="logo" width="150" height="120">
        <ul>
            <li><a href="admin_dashboard.php">Tableau de Bord</a></li>
            <li><a href="manage_messages.php">Gérer Messages</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="hero">
        <div class="content">
            <h1>Modifier <span>Utilisateur</span></h1>
        </div>
    </div>

    <section class="edit-profile">
        <div class="main">
            <form action="edit_user.php?user_id=<?= $user_id ?>" method="POST" enctype="multipart/form-data">
                <label for="username">Pseudonyme</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" value="<?= htmlspecialchars($user['password']); ?>" required>

                <label for="gender">Sexe</label>
                <select id="gender" name="gender" required>
                    <option value="male" <?= ($user['gender'] === 'male') ? 'selected' : ''; ?>>Homme</option>
                    <option value="female" <?= ($user['gender'] === 'female') ? 'selected' : ''; ?>>Femme</option>
                    <option value="other" <?= ($user['gender'] === 'other') ? 'selected' : ''; ?>>Autre</option>
                </select>

                <label for="birthdate">Date de naissance</label>
                <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($user['birthdate']); ?>" required>

                <label for="profession">Profession</label>
                <input type="text" id="profession" name="profession" value="<?= htmlspecialchars($user['profession']); ?>" required>

                <label for="residence">Lieu de résidence</label>
                <input type="text" id="residence" name="residence" value="<?= htmlspecialchars($user['residence']); ?>" required>

                <label for="relationship_status">Situation amoureuse</label>
                <select id="relationship_status" name="relationship_status" required>
                    <option value="Célibataire" <?= ($user['relationship_status'] === 'Célibataire') ? 'selected' : ''; ?>>Célibataire</option>
                    <option value="En couple" <?= ($user['relationship_status'] === 'En couple') ? 'selected' : ''; ?>>En couple</option>
                    <option value="Autre" <?= ($user['relationship_status'] === 'Autre') ? 'selected' : ''; ?>>Autre</option>
                </select>

                <label for="physical_description">Description physique</label>
            <textarea id="physical_description" name="physical_description" rows="4" required><?= htmlspecialchars($user['physical_description']); ?></textarea>

            <label for="personal_info">Message d'accueil</label>
            <input type="text" id="personal_info" name="personal_info" value="<?= htmlspecialchars($user['personal_info']); ?>" required>

            <label for="abonnement">Abonnement</label>
            <select id="abonnement" name="abonnement" required>
                <option value="aucun" <?= ($user['abonnement'] === 'aucun') ? 'selected' : ''; ?>>Aucun</option>
                <option value="basic" <?= ($user['abonnement'] === 'basic') ? 'selected' : ''; ?>>Basic</option>
                <option value="standard" <?= ($user['abonnement'] === 'standard') ? 'selected' : ''; ?>>Standard</option>
                <option value="premium" <?= ($user['abonnement'] === 'premium') ? 'selected' : ''; ?>>Premium</option>
            </select>

            <label for="photos">Photos</label>
            <input type="file" id="photos" name="photos">

            <div class="profile-img">
                <label for="photos">Photo actuelle</label>
                <img src="<?= htmlspecialchars($user['photos']); ?>" alt="Photo de profil">
            </div>
            <button type="submit" class="btn">Enregistrer les modifications</button>
        </form>
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




