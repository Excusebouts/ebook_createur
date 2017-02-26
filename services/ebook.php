<?php

require_once('constantes.php');
require_once('utils.php');

class Ebook {

	protected $titre;

	protected $images = array();

	protected $chemin;

	protected $index;

	public function __construct($titre) {
		$this->titre = $titre;
		$this->genererChemin();
		$this->genererIndex();
	}

	public function creerEbook() {
		if(true == mkdir($this->chemin)) {
			echo "Dossier ".$this->chemin." créé";
			Utils::copy_dir(Constantes::DOSSIER_TEMPLATE,$this->chemin);
		} else {
			echo "Impossible de créer le dossier ".$this->chemin;
		}

	}

	public function supprimerEbook() {

	}

	private function genererChemin() {
		$this->chemin = Constantes::DOSSIER_EBOOK.$this->titre."/";
	}

	private function genererIndex() {
		$this->index = $this->chemin.Constantes::INDEX_EBOOK;
	}

	public function getIndex() {
		return $this->index;
	}
}

?>