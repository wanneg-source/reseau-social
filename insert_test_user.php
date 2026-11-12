<?php


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>sans titre</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 2.0" />
</head>

<body>
	
  <?php
include 'config.php';
include 'db.php';

// Données test
$nom = "Test";
$prenom = "User";
$email = "test@example.com";
$pseudo = "testuser";
$motdepasse = password_hash("password123", PASSWORD_DEFAULT);
$avatar = "uploads/avatar1.jpg";

// Vérifie si le pseudo existe déjà
$check = mysqli_query($conn, "SELECT * FROM inscription WHERE pseudo = '$pseudo'");
if (mysqli_num_rows($check) > 0) {
    echo "Le pseudo '$pseudo' existe déjà.\n";
} else {
    // Insère l'utilisateur
    $sql = "INSERT INTO inscription (nom, prenom, email, pseudo, motdepasse, avatar) 
            VALUES ('$nom', '$prenom', '$email', '$pseudo', '$motdepasse', '$avatar')";
    if (mysqli_query($conn, $sql)) {
        echo "Utilisateur test inséré avec succès.\n";
    } else {
        echo "Erreur lors de l'insertion : " . mysqli_error($conn) . "\n";
    }
}
?>

</body>

</html>
