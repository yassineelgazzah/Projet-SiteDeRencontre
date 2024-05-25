<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les champs requis sont remplis
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {
        // Récupère les données du formulaire
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Adresse email du destinataire
        $to = "support@gmail.com";

        // Crée le message
        $message_content = "Nom: $name\n";
        $message_content .= "Email: $email\n\n";
        $message_content .= "Message:\n$message";

        // En-têtes du message
        $headers = "From: $name <$email>";

        // Envoi de l'email
        if (mail($to, $subject, $message_content, $headers)) {
            // Si l'email est envoyé avec succès
            echo "<p>Votre message a été envoyé avec succès. Nous vous contacterons bientôt.</p>";
        } else {
            // Si l'envoi de l'email échoue
            echo "<p>Désolé, une erreur s'est produite lors de l'envoi de votre message. Veuillez réessayer plus tard.</p>";
        }
    } else {
        // Si des champs requis ne sont pas remplis
        echo "<p>Tous les champs du formulaire sont requis.</p>";
    }
} else {
    // Si le formulaire n'a pas été soumis via la méthode POST
    echo "<p>Le formulaire n'a pas été soumis correctement.</p>";
}
?>





