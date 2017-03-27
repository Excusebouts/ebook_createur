<?php
/**
 * Page permettant de générer un mot de passe crypté pour insérer dans le Htaccess et en base de données
 *  
 * version     : 1.0.0 
 * @author 	   Vibey Cédric (cedric.vibey@gmail.com)
 */
if (isset($_POST['login']) AND isset($_POST['pass']))
{
    $login = $_POST['login'];
    $pass_crypte = crypt($_POST['pass']);
    echo '<p>Ligne à copier dans le .htpasswd :<br />' . $login . ':' . $pass_crypte . '</p>';
}
else 
{
?>
<p>Entrez votre login et votre mot de passe pour le crypter.</p>
<form method="post">
    <p>
        Login : <input type="text" name="login"><br />
        Mot de passe : <input type="text" name="pass"><br /><br />
        <input type="submit" value="Crypter !">
    </p>
</form>

<?php
}
?>