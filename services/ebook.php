<?php

require_once('parametres.php');
require_once('utils.php');
require_once('image.php');
require_once('writer.php');

class Ebook {

	protected $titre;

	protected $images = array();

	protected $chemin;

	protected $index;

	protected $index_template;

	protected $writer;

	public function __construct($titre,$images) {		
		$this->titre = $titre;
		$this->initImages($images);
		$this->genererChemin();
		$this->genererIndex();
		$this->writer = new Writer($this->index_template, $this->index, $this->titre, $this->images);
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
			$this->writer->ecrireFichier();
			unlink($this->index_template);
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
		$this->index_template = $this->chemin.Parametres::INDEX_EBOOK_TEMPLATE;
	}

	public function getIndex() {
		return $this->index;
	}
}

?>