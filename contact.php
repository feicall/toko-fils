<?php
// contact.php — réponse utilisée par assets/vendor/php-email-form/validate.js

// Inclure la connexion à la base (PDO)
require_once 'connexion.php';

// Charger PHPMailer (tu dois déjà avoir installé via Composer : composer require phpmailer/phpmailer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$destinataire = "imoroutoko125@gmail.com";

function getConfigValue($key) {
    $value = getenv($key);
    if ($value !== false && $value !== '') {
        return $value;
    }

    $envPath = __DIR__ . '/.env';
    if (!file_exists($envPath)) {
        return null;
    }

    $env = parse_ini_file($envPath, false, INI_SCANNER_RAW);
    if ($env === false || !isset($env[$key])) {
        return null;
    }

    return trim($env[$key]);
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Accès non autorisé.");
    }

    $nom     = trim($_POST['nom'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation simple
    if ($nom === '' || $email === '' || $message === '') {
        throw new Exception("Veuillez remplir tous les champs.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Adresse email invalide.");
    }

    // 📌 1. Insérer dans la base (version PDO)
    $sql = "INSERT INTO t_messages (nom, mail, sms, date) VALUES (:nom, :mail, :sms, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nom'  => $nom,
        ':mail' => $email,
        ':sms'  => $message
    ]);

    // 📌 2. Envoyer le mail avec PHPMailer
    $mail = new PHPMailer(true);

    // Config SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';       // Serveur SMTP (ex: Gmail)
    $mail->SMTPAuth   = true;
    $mail->Username   = getConfigValue('SMTP_USERNAME');
    $mail->Password   = getConfigValue('SMTP_PASSWORD');
    if (empty($mail->Username) || empty($mail->Password)) {
        throw new Exception("Configuration SMTP manquante (SMTP_USERNAME / SMTP_PASSWORD).");
    }
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS sécurisé
    $mail->Port       = 587;                    // Port TLS

    // Expéditeur
    $mail->setFrom($email, $nom);

    // Destinataire
    $mail->addAddress($destinataire);

    // Contenu
    $mail->isHTML(false); // texte brut
    $mail->Subject = "Nouveau message de $nom via le formulaire";
    $mail->Body    = "Nom : $nom\nEmail : $email\nMessage :\n$message";

    // Envoi
    if (!$mail->send()) {
        throw new Exception("Erreur lors de l'envoi : " . $mail->ErrorInfo);
    }

    echo "OK";
    exit;

} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
