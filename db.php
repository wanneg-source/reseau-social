<?php
// Connexion à la base de données
$conn = mysqli_connect('localhost', 'votre_utilisateur', 'votre_mot_de_passe', 'gestion_taches');

// Vérifier la connexion
if (!$conn) {
    die("❌ Échec de la connexion : " . mysqli_connect_error());
}

echo "✅ Connexion réussie à la base Barbie !";
?>
