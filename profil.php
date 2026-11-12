<?php
include 'config.php';
include 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo "Vous devez être connecté pour voir ce profil.";
    exit;
}

$id_connecte = (int)$_SESSION['id'];
$id_profil = isset($_GET['id']) ? (int)$_GET['id'] : $id_connecte;

// Récupération des infos du profil consulté
$res_user = mysqli_query($conn, "SELECT * FROM inscription WHERE id = $id_profil");
if (!$res_user || mysqli_num_rows($res_user) === 0) {
    echo "Profil introuvable.";
    exit;
}
$user = mysqli_fetch_assoc($res_user);

// Avatar : on construit le chemin à partir du nom du fichier uniquement
$avatar_path = 'uploads/' . basename($user['avatar']);
if (!empty($user['avatar']) && file_exists($avatar_path)) {
    $avatar = $avatar_path;
} else {
    $avatar = 'default-avatar.png';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de <?php echo htmlspecialchars($user['pseudo']); ?></title>
</head>
<body>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        padding: 0;
        color: #333;
    }

    h1, h2 {
        text-align: center;
        margin-top: 30px;
    }

    h1 {
        color: #28a745;
    }

    h2 {
        color: #007bff;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 30px;
    }

    .avatar {
        display: block;
        margin: 0 auto 20px auto;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #28a745;
    }

    p {
        font-size: 16px;
        line-height: 1.6;
        margin: 5px 0;
    }

    .post {
        border: 1px solid #ccc;
        background-color: #fafafa;
        padding: 15px;
        margin: 20px auto;
        border-radius: 8px;
        max-width: 700px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.05);
    }

    .post p {
        margin: 10px 0 5px 0;
    }

    .post small {
        color: #777;
        font-size: 12px;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .back-link {
        display: block;
        text-align: center;
        margin: 30px 0;
        font-weight: bold;
    }
</style>

    <div class="container">
    <h1>Profil de <?php echo htmlspecialchars($user['pseudo']); ?></h1>

    <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" class="avatar">

    <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
    <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>

<?php if ($id_connecte === $id_profil): ?>
    <!-- MESSAGES REÇUS -->
    <h2 style="color: green; text-align: center;">Vos messages reçus</h2>
    <?php
    $res_messages_recus = mysqli_query($conn, "
        SELECT m.contenu, m.date_envoi, i.id AS expediteur_id, i.pseudo AS expediteur_pseudo, m.visible_public 
        FROM messages m 
        JOIN inscription i ON m.expediteur_id = i.id 
        WHERE m.destinataire_id = $id_profil
        ORDER BY m.date_envoi DESC
    ");

    if ($res_messages_recus && mysqli_num_rows($res_messages_recus) > 0) {
        while ($message = mysqli_fetch_assoc($res_messages_recus)) {
            echo "<div class='post'>";
            echo "<strong>De : <a href='profil.php?id=" . (int)$message['expediteur_id'] . "'>" . htmlspecialchars($message['expediteur_pseudo']) . "</a></strong> — <small>" . date('d/m/Y H:i', strtotime($message['date_envoi'])) . "</small><br>";
            echo "<p>" . nl2br(htmlspecialchars($message['contenu'])) . "</p>";
            echo "<em>" . ($message['visible_public'] ? "(Public)" : "(Privé)") . "</em>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun message reçu.</p>";
    }

    echo "<h2 style='color: green; text-align: center;'>Vos messages envoyés</h2>";

    $res_messages_envoyes = mysqli_query($conn, "
        SELECT m.contenu, m.date_envoi, i.id AS destinataire_id, i.pseudo AS destinataire_pseudo, m.visible_public 
        FROM messages m 
        JOIN inscription i ON m.destinataire_id = i.id 
        WHERE m.expediteur_id = $id_connecte 
        ORDER BY m.date_envoi DESC
    ");

    if ($res_messages_envoyes && mysqli_num_rows($res_messages_envoyes) > 0) {
        while ($message = mysqli_fetch_assoc($res_messages_envoyes)) {
            echo "<div class='post'>";
            echo "<strong>À : <a href='profil.php?id=" . (int)$message['destinataire_id'] . "'>" . htmlspecialchars($message['destinataire_pseudo']) . "</a></strong> — <small>" . date('d/m/Y H:i', strtotime($message['date_envoi'])) . "</small><br>";
            echo "<p>" . nl2br(htmlspecialchars($message['contenu'])) . "</p>";
            echo "<em>" . ($message['visible_public'] ? "(Public)" : "(Privé)") . "</em>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun message envoyé.</p>";
    }

else:
    echo "<h2 style='color: green; text-align: center;'>Messages publics de " . htmlspecialchars($user['pseudo']) . "</h2>";

    $res_messages_publics = mysqli_query($conn, "
        SELECT m.contenu, m.date_envoi, i.id AS expediteur_id, i.pseudo AS expediteur_pseudo
        FROM messages m 
        JOIN inscription i ON m.expediteur_id = i.id 
        WHERE m.visible_public = 1 AND m.destinataire_id = $id_profil
        ORDER BY m.date_envoi DESC
    ");

    if ($res_messages_publics && mysqli_num_rows($res_messages_publics) > 0) {
        while ($message = mysqli_fetch_assoc($res_messages_publics)) {
            echo "<div class='post'>";
            echo "<strong>De : <a href='profil.php?id=" . (int)$message['expediteur_id'] . "'>" . htmlspecialchars($message['expediteur_pseudo']) . "</a></strong> — <small>" . date('d/m/Y H:i', strtotime($message['date_envoi'])) . "</small><br>";
            echo "<p>" . nl2br(htmlspecialchars($message['contenu'])) . "</p>";
            echo "<em>(Public)</em>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun message public disponible.</p>";
    }
endif;

echo "<h2 style='color: blue; text-align: center;'>Publications</h2>";

$res_posts = mysqli_query($conn, "
    SELECT contenu, date_post 
    FROM posts 
    WHERE user_id = $id_profil 
    ORDER BY date_post DESC
");

if ($res_posts && mysqli_num_rows($res_posts) > 0) {
    while ($post = mysqli_fetch_assoc($res_posts)) {
        echo "<div class='post'>";
        echo "<small>" . date('d/m/Y H:i', strtotime($post['date_post'])) . "</small><br>";
        echo "<p>" . nl2br(htmlspecialchars($post['contenu'])) . "</p>";
        echo "</div>";
    }
    }else {
    echo "<p>Aucune publication pour le moment.</p>";
    }
?>
    
    <a href="accueil.php" class="back-link"> <-- Retour à l'accueil</a>
    </div>
</body>
</html>
