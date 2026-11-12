<?php
 declare(strict_types = 1);
error_reporting(E_ALL);  //Demande à PHP de détecter tous les types d'erreurs 
ini_set("display_errors", 1); //Demande à PHP d'afficher ces erreurs dans le navigateur
require_once 'db.php';//inclut le fichier et arrête tout si le fichier n'existe pas
                      //include : inclut un fichier ou provoque un avertissement s’il n’est pas trouvé
  
    // verification que le formulaire à bien été soumis
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $Email = $_POST['Email'] ;
        $motdepass = $_POST['motdepass'];
        
        //isset()  vérifie si la variable existe et n'est pas null
        //empty() vérifie si la variable est vide (vide, null, 0, "")

        //verification des donner
        if(empty($Email) || empty($motdepass)){
            die("les champs ne doivent pas être vide");
        }
        $motdepass_hache = password_hash($motdepass, PASSWORD_DEFAULT);

        //verifier qu'on n'a bien un mail valide
        if(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
            die("Veuillez entrer une adresse email valide (ex: exemple@gmail.com)"); 
        }       
        
        // Vérification si l'Email existe déjà
        $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            echo "<p style='color:red;'>Vous avez déjà un compte. <a href='connexion.php'>Connectez-vous</a></p>";
            exit;
        }
            // Insertion des données dans la base de données
            $stmt = $conn->prepare("INSERT INTO user (Email, motdepass) VALUES (?, ?)");
            $stmt->bind_param("ss", $Email, $motdepass_hache);
            $stmt->execute();
            header("Location: connexion.php");
            exit;
   }

    
  
?>









<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
      <h2>Formulaire d'inscription</h2>
    <form method="POST">
        <label for="Email">Email</label>
            <input 
            type="email" 
            name ="Email" 
            id= "Email" 
            placeholder ="Email" required><br><br>
                
        <label for="motdepass">motdepass</label>
            <input 
            type="password" 
            name ="motdepass" 
            id= "motdepass" 
            placeholder ="motdepasse" required><br><br>
            <button type="submit">S'inscrire</button>                  
    </form>
    <a href="accueil.php">← Retour à l'accueil</a>

</body>