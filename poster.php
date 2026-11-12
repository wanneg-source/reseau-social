<?php
include 'config.php';
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit;
}

if (isset($_POST['contenu']) && !empty(trim($_POST['contenu']))) {
    $contenu = mysqli_real_escape_string($conn, $_POST['contenu']);
    $user_id = $_SESSION['id'];
    mysqli_query($conn, "INSERT INTO posts (user_id, contenu, date_post) VALUES ($user_id, '$contenu', NOW())");
}
header("Location: accueil.php");
exit;
?>