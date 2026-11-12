<?php
declare(strict_types = 1);
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
require_once 'db.php';
$id = $_GET['id'];
if(!isset($_SESSION['user_id'])){
    header("Location: connexion.php");
    exit;
}
// Récupérer le nom de la catégorie
$stmt = $conn->prepare("SELECT nom FROM categories WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$cat = $result->fetch_assoc();
$nom = $cat['nom'];

// Vérifier si des tâches utilisent cette catégorie
$check = $conn->prepare("SELECT COUNT(*) as total FROM taches WHERE categorie = ? AND user_id = ?");
$check->bind_param("si", $nom, $_SESSION['user_id']);
$check->execute();
$result2 = $check->get_result();
$row = $result2->fetch_assoc();

if($row['total'] > 0 && !isset($_POST['confirmer'])){
    // Afficher message de confirmation
    echo "<p style='color:red;'>Attention ! " . $row['total'] . " tâche(s) utilisent cette catégorie.</p>";
    echo "<form method='POST'>";
    echo "<button type='submit' name='confirmer'>Supprimer quand même</button> | ";
    echo "<a href='categories.php'>Annuler</a>";
    echo "</form>";
} else {
    // Supprimer
    $stmt2 = $conn->prepare("DELETE FROM categories WHERE id = ? AND user_id = ?");
    $stmt2->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt2->execute();
    header("Location: categories.php");
    exit;
}
?>