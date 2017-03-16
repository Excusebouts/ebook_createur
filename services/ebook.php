<?php

require_once('parametres.php');
require_once('utils.php');
require_once('image.php');
require_once('writer.php');

class Ebook {

	protected $titre;

	protected $images = array();

	protected $chemin;

	protected $chemin_pdf;

	protected $nom_zip;

	protected $chemin_zip;

	protected $index;

	protected $index_template;	

	protected $writer;

	public function __construct($titre,$images = null) {		
		$this->titre = $titre;		
		if($images != null) {
			$this->initImages($images);
		}
		$this->genererChemin();
		$this->genererIndex();
		if($images != null) {			
			$this->writer = new Writer($this->index_template, $this->index, $this->titre, $this->images);
		}
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

	public function zippageEbook() {
		return Utils::zipper_repertoire_recursif($this->nom_zip,$this->chemin,Parametres::DOSSIER_EBOOK);		
	}

	public function supprimerEbook() {
		$dir_iterator = new RecursiveDirectoryIterator($this->chemin);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::CHILD_FIRST);
		
		foreach($iterator as $fichier){
			$fichier->isDir() ? rmdir($fichier) : unlink($fichier);
		}
		
		rmdir($this->chemin);
		unlink($this->chemin_zip);
	}	
	
	private function genererChemin() {
		$this->chemin = Parametres::DOSSIER_EBOOK.$this->titre."/";
		$this->nom_zip = $this->titre.Parametres::EXTENSION_ZIP;
		$this->chemin_zip = Parametres::DOSSIER_EBOOK.$this->nom_zip;
		$this->chemin_pdf = $this->chemin.Parametres::FICHIER_PDF;

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

	public function getTitre() {
		return $this->titre;
	}

	public function getPDF() {
		return $this->chemin_pdf;
	}

	public function getCheminZip() {
		return $this->chemin_zip;
	}
}

?>