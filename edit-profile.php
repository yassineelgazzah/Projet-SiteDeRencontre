<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=meetgame", 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Récupérer l'ID de l'utilisateur depuis la session
$user_id = $_SESSION['user_id'];

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations actuelles de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $old_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$old_user) {
        die("Utilisateur non trouvé.");
    }

    // Mettre à jour les champs modifiables
    $fields = ['username', 'gender', 'birthdate', 'profession', 'residence', 'relationship_status', 'physical_description', 'personal_info', 'abonnement'];
    $params = [];
    foreach ($fields as $field) {
        if (isset($_POST[$field]) && $_POST[$field] !== $old_user[$field]) {
            $params[$field] = htmlspecialchars($_POST[$field]);
        } else {
            $params[$field] = $old_user[$field];
        }
    }

    // Vérifier si une nouvelle photo a été téléchargée
    if (!empty($_FILES['photos']['name'][0])) {
        $fileName = $_FILES['photos']['name'][0];
        $tmpFilePath = $_FILES['photos']['tmp_name'][0];
        $newFilePath = "uploads/" . basename($fileName);
        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            $params['photos'] = $newFilePath;
        } else {
            $params['photos'] = $old_user['photos'];
        }
    }

    $query = "UPDATE users SET " . implode("=?, ", array_keys($params)) . "=? WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array_values($params + ['id' => $user_id]));

    // Rediriger vers le tableau de bord après la mise à jour du profil
    header("Location: dashboard.php");
    exit();
}

// Récupérer les informations de l'utilisateur à partir de la base de données
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
    <title>Modifier le Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <img src="logo.png" class="logo" width="150" height="120">
        <ul>
            <li><a href="dashboard.php">Retour Tableau de Bord</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content">
            <h1>Modifier le <span>Profil</span></h1>
            <p class="para">Mettez à jour vos informations personnelles.</p>
        </div>
    </div>

    <!-- Edit Profile Section -->
    <section class="edit-profile">
        <div class="main">
            <form action="edit-profile.php" method="POST" enctype="multipart/form-data">
                <label for="pseudonyme">Pseudonyme</label>
                <input type="text" id="pseudonyme" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
                
                <label for="sexe">Sexe</label>
                <select id="sexe" name="gender" required>
                    <option value="male" <?= ($user['gender'] === 'male') ? 'selected' : ''; ?>>Homme</option>
                    <option value="female" <?= ($user['gender'] === 'female') ? 'selected' : ''; ?>>Femme</option>
                    <option value="other" <?= ($user['gender'] === 'other') ? 'selected' : ''; ?>>Autre</option>
                </select>

                <label for="date_naissance">Date de naissance</label>
                <input type="date" id="date_naissance" name="birthdate" value="<?= htmlspecialchars($user['birthdate']); ?>" required>
                
                <label for="profession">Profession</label>
                <input type="text" id="profession" name="profession" value="<?= htmlspecialchars($user['profession']); ?>" required>

                <label for="lieu_residence">Lieu de résidence</label>
                <input type="text" id="lieu_residence" name="residence" value="<?= htmlspecialchars($user['residence']); ?>" required>
                
                <label for="situation">Situation amoureuse</label>
                <select id="situation" name="relationship_status" required>
                    <option value="Célibataire" <?= ($user['relationship_status'] === 'Célibataire') ? 'selected' : ''; ?>>Célibataire</option>
                    <option value="En couple" <?= ($user['relationship_status'] === 'En couple') ? 'selected' : ''; ?>>En couple</option>
                    <option value="Autre" <?= ($user['relationship_status'] === 'Autre') ? 'selected' : ''; ?>>Autre</option>
                </select>

                <label for="description_physique">Description physique</label>
                <textarea id="description_physique" name="physical_description" rows="4" required><?= htmlspecialchars($user['physical_description']); ?></textarea>
                
                <label for="message_accueil">Message d'accueil</label>
                <input type="text" id="message_accueil" name="personal_info" value="<?= htmlspecialchars($user['personal_info']); ?>" required>        

                <div class="input-group">
                    <label for="photos">Photos</label>
                    <input type="file" id="photos" name="photos[]" accept="image/*">
                </div>
                <div class="profile-img">
                    <label for="photos">Photos actuelle</label>
                    <img src="<?= htmlspecialchars($user['photos']); ?>" alt="Photo de profil">
                </div>
                <button type="submit" class="btn">Enregistrer les modifications</button>
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


