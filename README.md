# Mini Réseau Social

## Description du projet

Application web de réseau social développée en **PHP** et **MySQL** dans le cadre de ma formation à l'Université de Rouen. Elle permet aux utilisateurs de s'inscrire, de se connecter, de gérer leur profil, de publier sur un fil d'actualité, d'échanger des messages privés et de partager des images.

### Fonctionnalités principales

- **Authentification & Sessions** (`inscription.php`, `connexion.php`, `deconnexion.php`) : Gestion des comptes utilisateurs et protection des accès.
- **Profils & Fil d'actualité** (`accueil.php`, `profil.php`, `poster.php`) : Publication de statuts et consultation des profils.
- **Messagerie privée** (`envoyer_message.php`) : Envoi et réception de messages entre membres.
- **Gestion des médias** (`uploads/`) : Upload et affichage des images partagées.

## Technologies utilisées

- **PHP 8** (Sessions, requêtes préparées, gestion des uploads)
- **MySQL / MariaDB** (Base de données relationnelle, schéma disponible dans `table_sql.pdf`)
- **HTML5 / CSS3**

## Installation et lancement

1. **Cloner le dépôt :**
   ```bash
   git clone [https://github.com/wanneg-source/reseau-social.git](https://github.com/wanneg-source/reseau-social.git)
   cd reseau-social
