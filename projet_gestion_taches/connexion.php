<?php
declare(strict_types = 1);
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = trim($_POST['Email']);
    $motdepass = $_POST['motdepass'];

    if (empty($Email) || empty($motdepass)) {
        die("Champs vides");
    }

    // Requête préparée
    $stmt = $conn->prepare("SELECT id, Email, motdepass FROM user WHERE Email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        // Vérification du mot de passe hashé
        if (password_verify($motdepass, $user['motdepass'])) {

            // Session utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['Email'] = $user['Email'];

           header("Location: dashboard.php");
            exit;

        } else {
            echo "<p style='color:red;'>Mot de passe incorrect</p>";
        }

    } else {
        echo "<p style='color:red;'>Utilisateur introuvable</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>

<h2>Connexion</h2>

<form method="POST">
    <label>Email</label><br>
    <input type="email" name="Email" required><br><br>

    <label>Mot de passe</label><br>
    <input type="password" name="motdepass" required><br><br>

    <button type="submit">Se connecter</button>
</form>


<a href="accueil.php">← Retour à l'accueil</a>

</body>
</html>