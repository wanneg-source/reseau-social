<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>
    <style>
     body {
    font-family: Arial, sans-serif;
    background:aliceblue ;
    margin: 0;
    padding: 0;
    text-align: center;
    color: gray;
}

/* Titre principal */
h1 {
    margin-top: 80px;
    font-size: 40px;
    color: Black;
}

/* Texte description */
p {
    font-size: 18px;
    margin: 20px auto;
    width: 60%;
    color: gray;
    font-style: italic;
}

/* Style général des boutons */
a {
    display: inline-block;
    margin: 15px;
    padding: 12px 25px;
    text-decoration: none;
    border-radius: 8px;
    font-size: 16px;
    transition: 0.3s;
    color: white;
}

/* Bouton inscription */
a[href="inscription.php"] {
    background-color: green;
}

a[href="inscription.php"]:hover {
    background-color: green;
}

/* Bouton connexion */
a[href="connexion.php"] {
    background-color: blue;
}

a[href="connexion.php"]:hover {
    background-color: blue;
}    
    </style>

<h1>Gestion de tâches</h1>

<p>Organise tes tâches, suis ton travail et reste efficace dans la gestion de tes projet!.</p>

<a href="inscription.php">Créer un compte</a> |
<a href="connexion.php">Se connecter</a>


</body>
</html>