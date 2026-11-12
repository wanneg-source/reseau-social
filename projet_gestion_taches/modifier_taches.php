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
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // On récupère les nouvelles valeurs du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    $datelimite = $_POST['datelimite'];
    $statut = $_POST['statut'];
    if(!empty($datelimite)){
       if(!preg_match("/^\d{4}-\d{2}-\d{2}$/", $datelimite)){
            die("La date n'est pas valide");
        }
    }
    
    $stmt = $conn->prepare("UPDATE taches SET title=?, description=?, categorie=?, datelimite=?, statut=? WHERE id=? AND user_id=?");
    $stmt->bind_param("sssssii", $titre, $description, $categorie, $datelimite, $statut, $id, $_SESSION['user_id']);
    $stmt->execute(); 
    header("Location: dashboard.php");
    exit;
} else {
   
    $stmt = $conn->prepare("SELECT * FROM taches WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $tache = $result->fetch_assoc(); // $tache contient toutes les données
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la tâche</title>
</head>
<body>
<h2>Modifier la tâche</h2>

<form method="POST">

    <label for="titre">Titre</label>
    <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($tache['title']); ?>" required><br><br>

    <label for="description">Description</label>
    <textarea name="description" rows="4"><?php echo htmlspecialchars($tache['description']); ?></textarea><br><br>

    <label for="categorie">Catégorie</label>
    <input type="text" id="categorie" name="categorie" value="<?php echo htmlspecialchars($tache['categorie']); ?>"><br><br>

    <label for="datelimite">Date limite</label>
    <input type="date" id="datelimite" name="datelimite" value="<?php echo htmlspecialchars($tache['datelimite']); ?>"><br><br>
    
    <label for="statut">Statut</label>
    <select name="statut">
        <option value="a faire" <?php if($tache['statut']=='a faire') echo 'selected'; ?>>À faire</option>
        <option value="en cours" <?php if($tache['statut']=='en cours') echo 'selected'; ?>>En cours</option>
        <option value="termine" <?php if($tache['statut']=='termine') echo 'selected'; ?>>Terminé</option>
    </select><br><br>
    <button type="submit">Enregistrer</button>
</form>
<a href="dashboard.php">← Retour au dashboard</a>
</body>
</html>
