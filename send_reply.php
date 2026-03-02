<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse email invalide.";
        exit;
    }
    if (empty($subject) || empty($message)) {
        echo "Sujet et message obligatoires.";
        exit;
    }

    $headers  = "From: TOKO & FILS <no-reply@toko-fils.com>\r\n";
    $headers .= "Reply-To: no-reply@toko-fils.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($email, $subject, $message, $headers)) {
        echo "Réponse envoyée avec succès ✅";
    } else {
        echo "Échec de l'envoi ❌";
    }
} else {
    echo "Requête invalide.";
}
