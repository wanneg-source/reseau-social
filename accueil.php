<?php
include 'config.php';
include 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    h1 {
        margin-top: 20px;
    }

    .form-container {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        width: 400px;
    }

    textarea, form input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    textarea {
        resize: vertical;
        min-height: 80px;
    }

    form input[type="submit"] {
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
    }

    form input[type="submit"]:hover {
        background-color: #218838;
    }

    .post {
        border: 1px solid #ccc;
        padding: 10px;
        margin: 0 auto 15px auto;
        border-radius: 5px;
        max-width: 600px;
        background-color: #fff;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        vertical-align: middle;
        margin-right: 10px;
    }

    a {
        text-decoration: none;
        color: #007bff;
    }

    a:hover {
        text-decoration: underline;
    }

    p, h1, h2 {
        text-align: center;
    }
    h2{
        color: green;
    }
</style>

<h1 style="color: green;">Bienvenue <?php echo isset($_SESSION['pseudo']) ? htmlspecialchars($_SESSION['pseudo']) : 'Visiteur'; ?></h1>

<?php if (isset($_SESSION['pseudo'])): ?>
    <div class="form-container">
        <form method="post" action="poster.php">
            <textarea name="contenu" placeholder="Exprimez-vous..." required></textarea>
            <input type="submit" value="Publier">
        </form>
    </div>

    <p>
        <a href="profil.php">Mon profil</a> | 
        <a href="envoyer_message.php">Envoyer un message</a> |
        <a href="deconnexion.php">Déconnexion</a>
    </p>
<?php else: ?>
    <p style="text-align: center;"><a href="connexion.php">Connexion</a> | <a href="inscription.php">Inscription</a></p>
<?php endif; ?>

<h2>Publications récentes</h2>
<?php
$query = "
    SELECT p.contenu, p.date_post, i.pseudo, i.avatar, i.id AS user_id
    FROM posts p
    JOIN inscription i ON p.user_id = i.id
    ORDER BY p.date_post DESC
";
$res = mysqli_query($conn, $query);

while ($post = mysqli_fetch_assoc($res)) {
    $formatted_date = date('d/m/Y H:i', strtotime($post['date_post']));
    $pseudo = htmlspecialchars($post['pseudo']);
    $contenu = nl2br(htmlspecialchars($post['contenu']));
    $user_id = (int)$post['user_id'];

    echo "<div class='post'>";
    echo "<strong>De: <a href='profil.php?id=$user_id'>$pseudo</a></strong> <small>($formatted_date)</small><br>";
    echo "<p>$contenu</p>";
    echo "</div>";
}
?>
</body>
</html>
