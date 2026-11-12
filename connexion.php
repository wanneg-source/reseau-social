<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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
            font-size: 24px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; 
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
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


        a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
<h2 style="color: green; text-align: center;">Connexion</h2>
<form method="post">
    <input type="text" name="pseudo" placeholder="Pseudo" required><br><br>
    <input type="password" name="motdepasse" placeholder="Mot de passe" required><br><br>
    <input type="submit" value="Se connecter">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';
    $pseudo = $_POST['pseudo'];
    $motdepasse = $_POST['motdepasse'];
    
    $pseudo = trim(strtolower($_POST['pseudo']));
    $motdepasse = trim($_POST['motdepasse']);
    
    $stmt = $conn->prepare("SELECT * FROM inscription WHERE LOWER(pseudo) = ?");
    $stmt->bind_param("s", $pseudo);
    $stmt->execute();
    $res = $stmt->get_result();
    
    echo "<p style='color:gray;'>Pseudo saisi : $pseudo</p>";




    $res = mysqli_query($conn, "SELECT * FROM inscription WHERE pseudo = '$pseudo'");
    if ($res && mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);
        if (password_verify($motdepasse, $user['motdepasse'])) {
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['id'] = $user['id'];
            header("Location: accueil.php");
            exit;
        } else {
            echo "<p class='error-message'>Mot de passe incorrect.</p>";
        }
    } else {
        echo "<p class='error-message'>Pseudo introuvable.</p>";
    }
}
?>
<br><a href="accueil.php"> <-- Retour à l'accueil</a>
</body>
</html>
