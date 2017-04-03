# ebook_createur
## Installation :

- Pour pouvoir utiliser la fonction de zip, ne pas oublier d'installer php-zip.

- Pour pouvoir utiliser la fonction de pdf, ne pas oublier d'installer php-tcpdf.

- Pour le .htaccess :
  1. Si pas actif, il faut rajouter dans le fichier de conf d'apache 2 (/etc/apache2/sites-available/000-default.conf) : <Directory "/var/www">AllowOverride All</Directory>
  2. Modifier le chemin dans le .htaccess du .htpasswd
  3. Pour ajouter un nouvel utilisateur au .htpasswd, utiliser le service htpasswd.php.
  4. Pour activer le rewrite : sudo a2enmod rewrite && sudo service apache2 restart

- Pour la BDD :
Passer le script utilisateur.sql se trouvant dans le dossier script/ sur la BDD
Configurer le fichier Parametres.sql avec les informations de connexion à la bdd (les champs commençant par BDD)

## Ajout d'un utilisateur

- Utiliser la page ebook.dalalu.fr/services/htpasswd.php pour générer un mot de passe sécurisé
- Si le .htaccess est disponible dans le dossier ebook : Ajouter le couple pseudo:mot de passe crypté dans le htpasswd pour donner accès aux ebooks
- Puis ajouter l'utilisateur en base. Pour cela aller dans phpMyAdmin base ebook, jouer la requête sql suivante en modifiant le pseudo et le mot de passe crypté par ceux indiqué par la page htpasswd.php : 

```
INSERT INTO Utilisateur (pseudo,pass,date_ajout)
VALUES ("pseudo","mot de passe crypté",SYSDATE());
```