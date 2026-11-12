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
    $nom = $_POST['nom'];

    if (empty($nom)){
        die("le Champs  est vides");
    }
    

    $stmt = $conn->prepare("INSERT INTO categories (nom, user_id) VALUES (?, ?)");
    $stmt->bind_param("si", $nom, $_SESSION['user_id']);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}
?>
















<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une categories</title>
</head>
<body>
    <h2>Créer une categorie </h2>

    <form method="POST">
      <label for="nom">Nom de la catégorie</label>
      <input type="text" id="nom" name="nom" placeholder="Ex: Études" required>
      <button type="submit">Créer</button>
    </form>

    <!--affichage des categories-->
    <h2>Mes catégories</h2>
    <?php
        $stmt2 = $conn->prepare("SELECT * FROM categories WHERE user_id = ?");
        $stmt2->bind_param("i", $_SESSION['user_id']);
        $stmt2->execute();
        $result = $stmt2->get_result();
   ?>
<?php while($cat = $result->fetch_assoc()){ ?>
        <p>
            <?php echo htmlspecialchars($cat['nom']); ?>
            <a href="supprimer_categorie.php?id=<?php echo $cat['id']; ?>">Supprimer</a>
        </p>
<?php } ?>
    <a href="dashboard.php">← Retour au dashboard</a>
    
</body>
</html>