<?php

require_once('parametres.php');

class Session {

	protected $id;

	protected $pseudo;

	protected $mot_de_passe;

	protected $connecte;

	protected $bdd;

	public function __construct($pseudo = null, $mot_de_passe = null) {
		$this->id = "";
		$this->pseudo = $pseudo;
		$this->mot_de_passe = $mot_de_passe;
		$this->connecte = false;
	}

	private function connectionBDD() {
		try {
			$this->bdd = new PDO('mysql:host='.Parametres::BDD_URL.';dbname='.Parametres::BDD_NOM.';charset=utf8', Parametres::BDD_UTILISATEUR, Parametres::BDD_PASS);
		}
		catch (Exception $e) {
	        die('Erreur : ' . $e->getMessage());
		}
	}

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
				echo "test";
				return true;
			} 
		}
		
		return false;
	}

	public function connexion() {			
		if($this->utilisateurExist() == true) {		
			session_start();
			$this->connecte = true;			
		}
	}

	public function deconnexion() {
		session_destroy();

		$this->connecte = false;	
	}


	public function estConnecte() {
		return $this->connecte;
	}

	public function getAuthentificationHTAccess() {
		return $this->pseudo.':'.$this->mot_de_passe;		
	}	

	public function getPseudo() {
		return $this->pseudo;
	}

	public static function verificationSession() {
		session_start();

		return !empty($_SESSION[Parametres::SESSION_VARIABLE]);
	}

	public static function setSession($session) {
		$_SESSION[Parametres::SESSION_VARIABLE] = $session;
	}

	public static function getSession() {
		if(session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		return $_SESSION[Parametres::SESSION_VARIABLE];
	}
	
}

?>