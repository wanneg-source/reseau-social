<?php
include 'config.php';
include 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $pseudo = mysqli_real_escape_string($conn, $_POST['pseudo']);
    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
    $avatar = $_POST['avatar']; // Avatar choisi parmi les options
    
    // Vérification si le pseudo existe déjà
    $check = mysqli_query($conn, "SELECT * FROM inscription WHERE pseudo = '$pseudo'");
    if (mysqli_num_rows($check) > 0) {
        echo "<p class='error-message'>Le pseudo est déjà pris. Choisissez-en un autre.</p>";
    } else {
        // Insertion des données dans la base de données
        $sql = "INSERT INTO inscription (nom, prenom, email, pseudo, motdepasse, avatar) 
                VALUES ('$nom', '$prenom', '$email', '$pseudo', '$motdepasse', '$avatar')";
        if (mysqli_query($conn, $sql)) {
            echo "<p class='success-message'>Inscription réussie !</p>";
            header("Location: connexion.php"); // Redirection vers la page de connexion
            exit;
        } else {
            echo "<p class='error-message'>Erreur : " . mysqli_error($conn) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; 
    flex-direction: column;
    }

    h2 {
        color: #28a745;
        margin-bottom: 20px;
        font-size: 28px;
        text-align: center;
    }

    form {
        background-color: #fff;
        padding: 7px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        box-sizing: border-box;
    }

    input[type="text"], input[type="password"], input[type="email"], select {
        width: 100%;
        padding: 7px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 7px;
        background-color: #28a745;
        border: none;
        border-radius: 5px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #218838;
    }

    label {
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
        display: block;
    }

    input[type="text"], input[type="password"], input[type="email"], select {
        margin-bottom: 5px;
    }

    a {
        color: #007bff;
        text-decoration: none;
        font-size: 16px;
        margin-top: 20px;
        text-align: center;
    }

    a:hover {
        text-decoration: underline;
    }


    .error-message {
        color: red;
        margin-top: 10px;
        font-size: 14px;
        text-align: center;
    }
    .success-message {
        color: green;
        margin-top: 10px;
        font-size: 14px;
        text-align: center;
    }
    </style>

    <h2>Formulaire d'inscription</h2>
    <form method="post">
        <input type="text" name="pseudo" placeholder="Pseudo" required><br><br>
        <input type="password" name="motdepasse" placeholder="Mot de passe" required><br><br>
        <input type="text" name="nom" placeholder="Nom" required><br><br>
        <input type="text" name="prenom" placeholder="Prénom" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>

        <label for="avatar">Choisir un avatar :</label>
        <select name="avatar" required>
            <option value="uploads/avatar1.jpg">Avatar 1</option>
            <option value="uploads/musan.jpg">Musan</option>
            <option value="uploads/naruto.jpg">Naruto</option>
            <option value="uploads/tangiro.jpg">Tangiro</option>
            <option value="uploads/zenitsu.jpg">Zenitsu</option>
            <option value="uploads/image.jpg">image</option>
            <option value="uploads/jack_bauer.jpeg">Jack Bauer</option>
        </select><br><br>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
