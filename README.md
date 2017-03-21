# ebook_createur
Installation :

- Pour pouvoir utiliser la fonction de zip, ne pas oublier d'installer php-zip.

- Pour le .htaccess :
1.Si pas actif, il faut rajouter dans le fichier de conf d'apache 2 (/etc/apache2/sites-available/000-default.conf) :
<Directory "/var/www">AllowOverride All</Directory>
2. Modifier le chemin dans le .htaccess du .htpasswd
3. Pour ajouter un nouvel utilisateur au .htpasswd, utiliser le service htpasswd.php.
4. Pour activer le rewrite : sudo a2enmod rewrite && sudo service apache2 restart

- Ajout d'un utilisateur :
Utiliser la page /services/htpasswd.php pour générer un mot de passe sécurisé
Ajouter le couple pseudo:mot de passe crypté dans le htpasswd pour donner accès aux ebooks
Ajouter le aussi en base, une requête d'exemple est présente dans le fichier utilisateur.sql dans le dossier script

- Pour la BDD :
Passer le script utilisateur.sql se trouvant dans le dossier script/ sur la BDD
Configurer le fichier Parametres.sql avec les informations de connexion à la bdd (les champs commençant par BDD)