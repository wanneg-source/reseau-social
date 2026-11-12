<?php 
 declare(strict_types = 1);
error_reporting(E_ALL);  //Demande à PHP de détecter tous les types d'erreurs 
ini_set("display_errors", 1); //Demande à PHP d'afficher ces erreurs dans le navigateur

// Connexion à la base de données
$conn = mysqli_connect('localhost', 'root', 'nina2318', 'gestion_taches');

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error()); //Renvoyer un message en cas d’erreur de connexion;
}

?>
