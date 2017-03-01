<?php

require_once('parametres.php');
require_once('utils.php');
require_once('image.php');

class Ebook {

	protected $titre;

	protected $images = array();

	protected $chemin;

	protected $index;

	public function __construct($titre,$images) {		
		$this->titre = $titre;
		$this->initImages($images);
		$this->genererChemin();
		$this->genererIndex();
	}

	private function initImages($images) {
		$i = 0;
		foreach($images as $image) {
			$this->images[$i] = new Image($image, $i);
			$i++;
		}		
	}

	public function creerEbook() {
		if(true == mkdir($this->chemin)) {
			echo "Dossier ".$this->chemin." créé";
			Utils::copy_dir(Parametres::DOSSIER_TEMPLATE,$this->chemin);
			for($i = 0 ; $i < sizeof($this->images) ; $i++) {
				$this->images[$i]->genererImage();
			}
		} else {
			echo "Impossible de créer le dossier ".$this->chemin;
		}

	}

	public function supprimerEbook() {

	}

	private function genererChemin() {
		$this->chemin = Parametres::DOSSIER_EBOOK.$this->titre."/";
		for($i = 0 ; $i < sizeof($this->images) ; $i++) {
			$this->images[$i]->genererChemin($this->chemin);
		}
	}

	private function genererIndex() {
		$this->index = $this->chemin.Parametres::INDEX_EBOOK;
	}

	public function getIndex() {
		return $this->index;
	}
}

?>