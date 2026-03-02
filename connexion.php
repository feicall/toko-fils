<?php 
try {
    $conn = new PDO("mysql:host=localhost;dbname=mailing", "root", "");
} catch (Exception $e) {
    die('Erreur' . $e->getMessage());
    echo'connexion failed';
}
?>
