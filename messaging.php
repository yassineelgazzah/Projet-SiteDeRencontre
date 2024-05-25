<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=meetgame", 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$currentUserId = $_SESSION['user_id'];

$sql = "SELECT users.id, users.username, 
               (SELECT message FROM messages 
                WHERE (sender_id = users.id AND receiver_id = :current_user_id) 
                   OR (sender_id = :current_user_id AND receiver_id = users.id) 
                ORDER BY sent_at DESC LIMIT 1) as last_message
        FROM users 
        WHERE users.id != :current_user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['current_user_id' => $currentUserId]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
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
            <li><a href="home.php">Page D'Accueil</a></li>
            <li><a href="dashboard.php">Tableau de Bord</a></li>
            <li><a href="search.php">Recherche</a></li>
            <li><a href="subscription.php">Abonnements</a></li>
            <li><a href="terms_of_service.php">Conditions d'Utilisation</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="hero">
        <div class="content">
            <h1>Messagerie</h1>
        </div>
    </div>

    <section class="messaging">
        <div class="main">
            <div class="conversations">
                <h2>Conversations</h2>
                <div class="conversation-list">
                    <?php foreach ($users as $user): ?>
                        <div class="conversation" data-user-id="<?= htmlspecialchars($user['id']); ?>">
                            <p><strong><?= htmlspecialchars($user['username']); ?></strong></p>
                            <p><?= htmlspecialchars($user['last_message'] ?: 'Aucun message'); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="chat">
                <h2 id="chatWith">Chat avec Utilisateur</h2>
                <div class="chat-messages" id="chatMessages">
                    <!-- Messages seront chargés dynamiquement ici -->
                </div>
                <form class="message-form" id="messageForm">
                    <input type="text" id="messageInput" placeholder="Écrire un message..." required>
                    <button type="submit">Envoyer</button>
                </form>
            </div>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const conversations = document.querySelectorAll('.conversation');
    const chatWith = document.getElementById('chatWith');
    const chatMessages = document.getElementById('chatMessages');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    let selectedUserId = null;

    conversations.forEach(conversation => {
        conversation.addEventListener('click', function() {
            selectedUserId = this.getAttribute('data-user-id');
            chatWith.textContent = `Chat avec ${this.querySelector('strong').textContent}`;
            loadMessages();
        });
    });

    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (selectedUserId) {
            sendMessage();
        }
    });

    function loadMessages() {
        fetch(`loadMessages.php?user_id=${selectedUserId}`)
            .then(response => response.json())
            .then(messages => {
                chatMessages.innerHTML = '';
                messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message');
                    messageElement.textContent = `${message.sender_id == <?php echo $_SESSION['user_id']; ?> ? 'Vous' : 'Lui'}: ${message.message}`;
                    const reportButton = document.createElement('button');
                    reportButton.textContent = 'Signaler';
                    reportButton.addEventListener('click', function() {
                        reportMessage(message.id);
                    });
                    messageElement.appendChild(reportButton);
                    chatMessages.appendChild(messageElement);
                });
            });
    }

    function sendMessage() {
        const message = messageInput.value;
        fetch('sendMessage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ recipient_id: selectedUserId, message: message })
        }).then(response => response.json()).then(data => {
            if (data.success) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('message');
                messageElement.textContent = `Vous: ${message}`;
                const reportButton = document.createElement('button');
                reportButton.textContent = 'Signaler';
                messageElement.appendChild(reportButton);
                chatMessages.appendChild(messageElement);
                messageInput.value = '';
            }
        });
    }

    function reportMessage(messageId) {
        fetch('reportMessage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message_id: messageId })
        }).then(response => response.json()).then(data => {
            if (data.success) {
                alert('Message signalé');
            } else {
                alert('Échec du signalement du message');
            }
        });
    }
});

</script>
</body>
</html>
