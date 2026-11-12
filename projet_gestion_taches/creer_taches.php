<?php
declare(strict_types = 1);
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $categories = $_POST['categories'];
    $datelimite = !empty($_POST['datelimite']) ? $_POST['datelimite'] : NULL;
    $statut = $_POST['statut'];

    if (empty($titre) || empty($categories)) {
        die("Champs vides");
    }
    if(!empty($datelimite)){
       if(!preg_match("/^\d{4}-\d{2}-\d{2}$/", $datelimite)){
            die("La date n'est pas valide");
        }
    }
    

    $stmt = $conn->prepare("INSERT INTO taches (title, description, categorie, datelimite, statut, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $titre, $description, $categories, $datelimite, $statut, $_SESSION['user_id']);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}

?>










<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une tâche</title>
</head>
<body>
    <h2>Créer une tâche</h2>

    <form method="POST">

        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" placeholder="Titre" required><br><br>

        <label for="description">Description</label>
        <textarea name="description" rows="4" placeholder="Description"></textarea><br><br>

        <label for="categories">Catégorie</label>
        <select name="categories">
            <?php
                $stmt2 = $conn->prepare("SELECT * FROM categories WHERE user_id = ?");
                $stmt2->bind_param("i", $_SESSION['user_id']);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                while($cat = $result2->fetch_assoc()){
                    echo "<option value='" . htmlspecialchars($cat['nom']) . "'>" . htmlspecialchars($cat['nom']) . "</option>";
                }
            ?>
       </select><br><br>
        <label for="datelimite">Date limite</label>
        <input type="date" id="datelimite" name="datelimite"><br><br>

        <label for="statut">Statut</label>
        <select name="statut">
            <option value="a faire">À faire</option>
            <option value="en cours">En cours</option>
            <option value="termine">Terminé</option>
        </select><br><br>

        <button type="submit">Créer</button>
    </form>
    <a href="dashboard.php">← Retour au dashboard</a>
</body>
</html>