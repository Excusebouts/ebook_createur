# ebook_createur
Installation :

- Pour la fonction de zip, ne pas oublier d'installer php-zip.

- Pour le .htaccess :
1.Si pas actif, il faut rajouter dans le fichier de conf d'apache 2 (/etc/apache2/sites-available/000-default.conf) :
<Directory "/var/www">
    AllowOverride All
</Directory>
2.Modifier le chemin dans le .htaccess du .htpasswd
3.Pour ajouter un nouvel utilisateur au .htpasswd, utiliser le service htpasswd.php.
