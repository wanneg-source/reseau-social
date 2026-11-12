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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>tableau de board</title>
    <script src="tri.js" defer></script>
</head>
<body>

<h2>Bienvenue <?php echo htmlspecialchars($_SESSION['Email']); ?> !</h2>

<a href="creer_taches.php">Créer une tâche</a><br><br>

<button onclick="trierPar(0)">Trier par titre</button>
<button onclick="trierPar(2)">Trier par catégorie</button>
<button onclick="trierPar(3)">Trier par statut</button>
<button onclick="trierPar(4)">Trier par date limite</button>

<a href="deconnexion.php">Se déconnecter</a><br><br>

  <?php
       $stmt = $conn->prepare("SELECT * FROM taches WHERE user_id = ?");
       $stmt->bind_param("i", $_SESSION['user_id']); 
       $stmt->execute(); 
       $result = $stmt->get_result(); 
       
  ?>
  <!--Affichage des taches avec un tableau -->
  <table>
    <tr>
        <th>Titre</th> 
        <th>Description</th> 
        <th>Catégorie</th> 
        <th>Statut</th> 
        <th>Date limite</th> 
        <th>Actions</th>
    </tr>
    <?php while($tache = $result->fetch_assoc()){ ?>
        <tr>
                <td><?php echo htmlspecialchars($tache['title']); ?></td>
                <td><?php echo htmlspecialchars($tache['description']); ?></td>
                <td><?php echo htmlspecialchars($tache['categorie']); ?></td>
                <td><?php echo htmlspecialchars($tache['statut']); ?></td>
                <td><?php echo htmlspecialchars($tache['datelimite'] ?? ''); ?></td>                
                <td>
                    <a href="modifier_taches.php?id=<?php echo $tache['id']; ?>">Modifier</a>
                    <a href="supprimer_taches.php?id=<?php echo $tache['id']; ?>">Supprimer</a>
                </td>
        </tr>
    <?php } ?>
</table>


<a href="accueil.php">← Retour à l'accueil</a><br><br>
<a href="categories.php">Gérer mes catégories</a>

</body>
</html>