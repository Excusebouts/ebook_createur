<?php

require_once('parametres.php');

class Session {

	protected $id;

	protected $pseudo;

	protected $mot_de_passe;

	protected $connecte;

	public function __construct($pseudo = null, $mot_de_passe = null) {
		$this->id = "";
		$this->pseudo = $pseudo;
		$this->mot_de_passe = $mot_de_passe;
		$this->connecte = false;
	}

	public function connexion() {	
		if($this->pseudo == "test" && $this->mot_de_passe == "test") {		
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

	public static function verificationSession() {
		session_start();

		return !empty($_SESSION[Parametres::SESSION_VARIABLE]);
	}

	public static function setSession($session) {
		$_SESSION[Parametres::SESSION_VARIABLE] = $session;
	}

	public static function getSession() {
		session_start();

		return $_SESSION[Parametres::SESSION_VARIABLE];
	}
	
}

?>