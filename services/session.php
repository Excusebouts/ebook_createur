<?php

require_once('parametres.php');

/**
 * Classe contenant la gestion de la session utilisateur php
 *
 * version     : 1.0.0
 * @author     Vibey Cédric (cedric.vibey@gmail.com)
 */
class Session {

	// Contient l'id de session
	protected $id;

	// Contient le pseudo de session
	protected $pseudo;

	// Contient le mot de passe de session
	protected $mot_de_passe;

	// Contient si oui ou non l'utilisateur est connecté
	protected $connecte;

	// Contient le lien vers la base de données
	protected $bdd;

	/**
	 * Constructeur par défaut de la session
	 *
	 * @param      string  $pseudo        Le pseudo de l'utilisateur
	 * @param      string  $mot_de_passe  Le mot de passe de l'utilisateur
	 */
	public function __construct($pseudo = null, $mot_de_passe = null) {
		$this->id = "";
		$this->pseudo = $pseudo;
		$this->mot_de_passe = $mot_de_passe;
		$this->connecte = false;
	}

	/**
	 * Connexion à la base de données
	 */
	private function connectionBDD() {
		try {
			$this->bdd = new PDO('mysql:host='.Parametres::BDD_URL.';dbname='.Parametres::BDD_NOM.';charset=utf8', Parametres::BDD_UTILISATEUR, Parametres::BDD_PASS);
		}
		catch (Exception $e) {
	        die('Erreur : ' . $e->getMessage());
		}
	}

	/**
	 * Vérifie si l'utilisateur existe en base de données
	 *
	 * @return     boolean  True si l'utilisateur existe, false sinon
	 */
	private function utilisateurExist() {
		$this->connectionBDD();

		$req = $this->bdd->prepare('SELECT id, pass FROM Utilisateur WHERE pseudo = :pseudo');
		$req->execute(array(
		    'pseudo' => $this->pseudo
	    ));

		$resultat = $req->fetch();
		$this->bdd = null;

		if(!empty($resultat)) {				
			if(crypt($this->mot_de_passe, $resultat['pass']) == $resultat['pass']) {				
				return true;
			} 
		}
		
		return false;
	}

	/**
	 * Démarre une session php pour l'utilisateur
	 */
	public function connexion() {			
		if($this->utilisateurExist() == true) {		
			session_start();
			$this->connecte = true;			
		}
	}

	/**
	 * Ferme une session pour l'utilisateur
	 */
	public function deconnexion() {
		session_destroy();

		$this->connecte = false;	
	}


	/**
	 * Vérifie si l'utilisateur est connecte
	 *
	 * @return     boolean  True si l'utilisateur est connecté, false sinon
	 */
	public function estConnecte() {
		return $this->connecte;
	}

	/**
	 * Donne les acces Htaccess suivant la session php
	 *
	 * @return     string  L'authentification Htaccess
	 */
	public function getAuthentificationHTAccess() {
		return $this->pseudo.':'.$this->mot_de_passe;		
	}	

	/**
	 * Donne le pseudo de l'utilisateur
	 *
	 * @return     string  Le pseudo
	 */
	public function getPseudo() {
		return $this->pseudo;
	}

	/**
	 * Vérifie qu'une session php est bien active
	 *
	 * @return     boolean  True si une session est active, false sinon
	 */
	public static function verificationSession() {
		session_start();

		return !empty($_SESSION[Parametres::SESSION_VARIABLE]);
	}

	/**
	 * Modifie la session php
	 *
	 * @param      session  $session  La session de l'utilisateur
	 */
	public static function setSession($session) {
		$_SESSION[Parametres::SESSION_VARIABLE] = $session;
	}

	/**
	 * Donne la session php
	 *
	 * @return     session  La session php de l'utilisateur
	 */
	public static function getSession() {
		if(session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		return $_SESSION[Parametres::SESSION_VARIABLE];
	}
	
}

?>