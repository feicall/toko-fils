<?php
session_start();
require_once 'connexion.php';

// Déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit;
}

// Suppression d’un message si demandé
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $sql = "DELETE FROM t_messages WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $delete_id]);
}

// Vérification des accès (ton code actuel)
if (isset ($_POST['send'])) {
    $mpd1= $_POST['nom'];
    $mdp2= $_POST['email'];
}
$md1='toko&fils';
$md2='imoroutoko125@gmail.com';

if($mdp1= !$md1 AND $mdp2= $md2){
        echo"MOTS DE PASSES INCORRECTES";
} else {
    // Si connexion réussie, on stocke en session
    $_SESSION['user'] = "admin";

    // Récupérer les messages
    $sql = "SELECT * FROM t_messages ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TOKO & FILS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        .table-responsive { border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .message-cell { max-width: 300px; word-wrap: break-word; }
        .btn-reply { background-color: #28a745; border-color: #28a745; color: white; }
        .btn-reply:hover { background-color: #218838; border-color: #1e7e34; color: white; }
        .btn-delete { background-color: #dc3545; border-color: #dc3545; color: white; }
        .btn-delete:hover { background-color: #b02a37; border-color: #a52834; color: white; }
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; padding: 2rem 0; margin-bottom: 2rem;
        }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-building me-2"></i> TOKO & FILS</a>
        <div class="d-flex">
            <a href="?logout=1" class="btn btn-outline-light btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
            </a>
        </div>
    </div>
</nav>


<!-- Header -->
<div class="dashboard-header">
    <div class="container">
        <h1 class="display-4"><i class="fas fa-tachometer-alt me-3"></i>Votre Tableau de bord</h1>
        <p class="lead">Gérez vos messages et communications</p>
    </div>
</div>

<!-- Messages -->
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3"><i class="fas fa-envelope me-2 text-primary"></i>Messages Reçus</h2>
                <span class="badge bg-primary fs-6"><?= count($messages) ?> messages</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th><th>Email</th><th>Message</th><th>Date</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($msg['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($msg['mail']) ?></td>
                                <td class="message-cell"><?= nl2br(htmlspecialchars($msg['sms'])) ?></td>
                                <td><small><?= $msg['date'] ?></small></td>
                                <td class="d-flex gap-2">
                                    <!-- Bouton Répondre -->
                                    <button class="btn btn-reply btn-sm"
                                        data-id="<?= $msg['id'] ?>"
                                        data-name="<?= htmlspecialchars($msg['nom']) ?>"
                                        data-email="<?= htmlspecialchars($msg['mail']) ?>"
                                        data-bs-toggle="modal" data-bs-target="#replyModal">
                                        <i class="fas fa-reply me-1"></i>Répondre
                                    </button>

                                    <!-- Bouton Supprimer -->
                                    <form method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce message ?');">
                                        <input type="hidden" name="delete_id" value="<?= $msg['id'] ?>">
                                        <button type="submit" class="btn btn-delete btn-sm">
                                            <i class="fas fa-trash me-1"></i>Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($messages)): ?>
                            <tr><td colspan="5" class="text-center">Aucun message trouvé.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Répondre -->
<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-reply me-2"></i>Répondre au message</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="replyForm">
                    <input type="hidden" id="replyMessageId" name="id">
                    <div class="mb-3">
                        <label class="form-label">Destinataire</label>
                        <input type="text" class="form-control" id="recipientName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="recipientEmail" name="email" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sujet</label>
                        <input type="text" class="form-control" id="replySubject" name="subject">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" id="replyMessage" name="message" rows="5"></textarea>
                    </div>
                </form>
                <div id="replyStatus" class="text-success fw-bold"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Annuler</button>
                <button class="btn btn-primary" id="sendReply"><i class="fas fa-paper-plane me-1"></i>Envoyer</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.btn-reply').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('replyMessageId').value = this.dataset.id;
        document.getElementById('recipientName').value = this.dataset.name;
        document.getElementById('recipientEmail').value = this.dataset.email;
    });
});

document.getElementById('sendReply').addEventListener('click', function () {
    let formData = new FormData(document.getElementById('replyForm'));

    fetch('send_reply.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById('replyStatus').innerHTML = data;
    })
    .catch(err => {
        document.getElementById('replyStatus').innerHTML = "Erreur lors de l'envoi.";
    });
});
</script>
</body>
</html>
<?php } ?>
