<?php

require_once('parametres.php');
require_once('utils.php');
require_once('image.php');
require_once('writer.php');
require_once('pdf.php');

/**
 * Classe contenant la structure de données d'un ebook
 *
 * version     : 1.0.0
 * @author     Vibey Cédric (cedric.vibey@gmail.com)
 */
class Ebook {

	// Le titre de l'ebook
	protected $titre;

	// Une liste d'images affiché dans l'ebook
	protected $images = array();

	// L'endroit où se situe l'ebook
	protected $chemin;

	// Le nom du zip de l'ebook
	protected $nom_zip;

	// L'endroit où se situe le zip de l'ebook
	protected $chemin_zip;

	// L'endroit où se situe le html d'affichage du ebook
	protected $index;

	// L'endroit où se situe le template html de l'ebook
	protected $index_template;	

	// L'objet qui permet d'écrire à l'intérieur du template
	protected $writer;

	// L'objet qui permet de générer un pdf
	protected $pdf;

	/**
	 * Constructeur par défaut d'un ebook
	 *
	 * @param      string  $titre   Le titre de l'ebook
	 * @param      array  $images  Les images de l'ebook, peut être null si l'ebook n'est pas en création mais en lecture
	 */
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
		$this->pdf = new Pdf($this->images, $this->chemin, $this->titre);
	}

	/**
	 * Initialise toutes les images de l'ebook
	 *
	 * @param      array  $images  Les images de l'ebook
	 */
	private function initImages($images) {
		$i = 0;
		foreach($images as $image) {
			$this->images[$i] = new Image($image, $i);
			$i++;
		}		
	}

	/**
	 * Réalise toutes les opérations nécessaires à la création d'une ebook
	 */
	public function creerEbook() {
		if(true == mkdir($this->chemin)) {			
			Utils::copy_dir(Parametres::DOSSIER_TEMPLATE,$this->chemin);
			for($i = 0 ; $i < sizeof($this->images) ; $i++) {
				$this->images[$i]->genererImage();
			}
			$this->writer->ecrireFichier();
			unlink($this->index_template);
			$this->pdf->genererPDF();
		} 
	}

	/**
	 * Zip un ebook
	 *
	 * @return     <boolean>  true si le zippage c'est bien déroulé, false sinon
	 */
	public function zippageEbook() {
		return Utils::zipper_repertoire_recursif($this->nom_zip,$this->chemin,Parametres::DOSSIER_EBOOK);		
	}

	/**
	 * Réalise toutes les opérations nécessaires à la suppression d'une ebook
	 */
	public function supprimerEbook() {
		$dir_iterator = new RecursiveDirectoryIterator($this->chemin);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::CHILD_FIRST);
		
		foreach($iterator as $fichier){
			$fichier->isDir() ? rmdir($fichier) : unlink($fichier);
		}
		
		rmdir($this->chemin);
		unlink($this->chemin_zip);
	}	
	
	/**
	 * Génère tous les chemins nécessaires à un ebook
	 */
	private function genererChemin() {
		$this->chemin = Parametres::DOSSIER_EBOOK.$this->titre."/";
		$this->nom_zip = $this->titre.Parametres::EXTENSION_ZIP;
		$this->chemin_zip = Parametres::DOSSIER_EBOOK.$this->nom_zip;		

		for($i = 0 ; $i < sizeof($this->images) ; $i++) {
			$this->images[$i]->genererChemin($this->chemin);
		}
	}

	/**
	 * Génère tous les chemins nécessaires pour l'accès au html d'un ebook
	 */
	private function genererIndex() {
		$this->index = $this->chemin.Parametres::INDEX_EBOOK;
		$this->index_template = $this->chemin.Parametres::INDEX_EBOOK_TEMPLATE;
	}

	/**
	 * Donne l'url d'accès d'une session Htaccess.
	 *
	 * @param      session  $session  Les identifiants Htaccess de la session
	 * @param      string  $domaine  Le domaine du site web
	 *
	 * @return     string  l'url htaccess d'accès à la session
	 */
	private function getCheminSession($session, $domaine) {
		return Parametres::URL_HTTP.$session->getAuthentificationHTAccess().'@'.$domaine;
	}

	/**
	 * Donne l'adresse du fichier html d'affichage de l'ebook
	 *
	 * @return     string  L'adresse du fichier html de l'ebook
	 */
	public function getIndex() {
		return $this->index;
	}

	/**
	 * Donne l'adresse du fichier html d'affichage de l'ebook dans une session Htaccess
	 *
	 * @param      session  $session  Les identifiants Htaccess de la session
	 * @param      string  $domaine  Le domaine du site web
	 *
	 * @return     string  L'adresse du fichier html de l'ebook dans une session Htaccess
	 */
	public function getIndexSession($session, $domaine) {
		return $this->getCheminSession($session, $domaine).Parametres::DOSSIER_EBOOK_NOM.$this->titre.'/'.Parametres::INDEX_EBOOK;
	}

	/**
	 * Donne le titre de l'ebook
	 *
	 * @return     string  Le titre de l'ebook.
	 */
	public function getTitre() {
		return $this->titre;
	}

	/**
	 * Donne le chemin du PDF de l'ebook
	 *
	 * @return     string  Le chemin du PDF de l'ebook
	 */
	public function getPDF() {
		return $this->pdf->getCheminPDF();
	}

	/**
	 * Donne le chemin du PDF de l'ebook dans une session Htaccess
	 *
	 * @param      session  $session  Les identifiants Htaccess de la session
	 * @param      string  $domaine  Le domaine du site web
	 *
	 * @return     string  L'adresse du fichier PDF de l'ebook dans une session Htaccess
	 */
	public function getPDFSession($session, $domaine) {
		return $this->getCheminSession($session, $domaine).Parametres::DOSSIER_EBOOK_NOM.$this->titre.'/'.Parametres::FICHIER_PDF;
	}

	/**
	 * Donne le chemin du zip contenant l'ebook.
	 *
	 * @return     string  L'adresse du zip contenant l'ebook
	 */
	public function getCheminZip() {
		return $this->chemin_zip;
	}

	/**
	 * Donne le chemin du zip contenant l'ebook dans une session Htaccess
	 *
	 * @param      session  $session  Les identifiants Htaccess de la session
	 * @param      string  $domaine  Le domaine du site web
	 *
	 * @return     string  L'adresse du fichier PDF de l'ebook dans une session Htaccess
	 */
	public function getCheminZipSession($session, $domaine) {
		return $this->getCheminSession($session,$domaine).Parametres::DOSSIER_EBOOK_NOM.'/'.$this->nom_zip;
	}	
}

?>