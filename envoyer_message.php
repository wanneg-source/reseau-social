<?php
include 'config.php';
include 'db.php';

// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo "Vous devez être connecté pour envoyer un message.";
    exit;
}

// Traitement du formulaire lorsque soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier que les champs nécessaires sont remplis
    if (isset($_POST['contenu'], $_POST['destinataire'], $_POST['visibilite'])) {
        $contenu = mysqli_real_escape_string($conn, $_POST['contenu']);
        $destinataire_pseudo = mysqli_real_escape_string($conn, $_POST['destinataire']);
        $visibilite = ($_POST['visibilite'] == 'public') ? 1 : 0;

        // Requête pour obtenir l'ID du destinataire
        $res_destinataire = mysqli_query($conn, "SELECT id FROM inscription WHERE pseudo = '$destinataire_pseudo'");
        $destinataire = mysqli_fetch_assoc($res_destinataire);

        if ($destinataire) {
            $destinataire_id = $destinataire['id'];
            $expediteur_id = $_SESSION['id'];

            // Insertion du message dans la base de données
            $sql = "INSERT INTO messages (expediteur_id, destinataire_id, contenu, visible_public) 
                    VALUES ($expediteur_id, $destinataire_id, '$contenu', $visibilite)";

            if (mysqli_query($conn, $sql)) {
                echo "<p style='color: green; text-align: center; padding-top: 10px;'>Message envoyé avec succès!</p>";
            } else {
                echo "<p style='color: red; text-align: center; padding-top: 10px;'>Erreur lors de l'envoi du message : </p>" . mysqli_error($conn);
            }
        } else {
            echo "<p style='color: red; text-align: center; padding-top: 10px;'>Destinataire introuvable.</p>";
        }
    } else {
        echo "<p style='color: red; text-align: center; padding-top: 10px;'>Veuillez remplir tous les champs.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Envoyer un message</title>
</head>
<body>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 40px;
            color: green;
        }

        form {
            background-color: #fff;
            width: 400px;
            margin: 30px auto;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Envoyez un message</h2>
    <form method="post">
        <input type="text" name="destinataire" placeholder="Pseudo du destinataire" required>
        <textarea name="contenu" rows="5" placeholder="Votre message..." required></textarea>
        <label>Visibilité :</label>
        <select name="visibilite">
            <option value="prive">Privé</option>
            <option value="public">Public</option>
        </select>
        <input type="submit" value="Envoyer">
    </form>
    <br><a href="accueil.php"> <-- Retour à l'accueil</a>
</body>
</html>
