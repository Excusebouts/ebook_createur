<?php

require_once('parametres.php');

/**
 * Classe contenant la structure de données d'une image dans un ebook
 *
 * version     : 1.0.0
 * @author     Vibey Cédric (cedric.vibey@gmail.com)
 */
class Image {

	// Le numéro de page correspondant à une image
	protected $page;

	// Le nom de l'image à uploader sur le serveur
	protected $nom_upload;

	// Le type d'image
	protected $type;

	// L'extension de l'image
	protected $extension;

	// Le chemin temporaire de l'image dans le navigateur
	protected $chemin_temporaire;

	// Le chemin de l'image dans l'ebook
	protected $chemin;

	// Le chemin de l'image large dans l'ebook
	protected $chemin_large;

	// Le nom de la vignette correspondant à l'image
	protected $nom_thumb;

	// Le chemin de la vignette correspondant à l'image
	protected $chemin_thumb;

	// L'erreur lors de l'upload de l'image
	protected $erreur;

	// La taille de l'image
	protected $taille;

	/**
	 * Constructeur par défaut d'une image contenu dans un ebook
	 *
	 * @param      array   $image  Les informations d'une image uploadée
	 * @param      integer  $page   Le numéro de page associée à l'image
	 */
	public function __construct($image,$page) {		
		$this->page = $page + 1;
		$this->nom_upload = $image['name'];
		$this->type = $image['type'];
		$this->extension = strrchr($image['name'], '.');
		$this->chemin_temporaire = $image['tmp_name'];
		$this->erreur = $image['error'];
		$this->taille = $image['size'];
		$this->chemin = "";
		$this->upload_succes = false;
	}

	/**
	 * Déplace les images uploadés dans le répertoire correspondant dans l'ebook
	 */
	public function genererImage() {
		if($this->isImageActive()) {
			if(move_uploaded_file($this->chemin_temporaire,$this->chemin)) {
				copy($this->chemin, $this->chemin_large);
				copy($this->chemin, $this->chemin_thumb);				
			} 
		}
	}

	/**
	 * Initialise les chemins des images contenu dans l'ebook
	 *
	 * @param      string  $chemin  Le chemin de l'ebook
	 */
	public function genererChemin($chemin) {
		$this->chemin = $chemin.Parametres::DOSSIER_IMAGES.$this->page.$this->extension;
		$this->chemin_large = $chemin.Parametres::DOSSIER_IMAGES.$this->page.Parametres::EXTENSION_IMAGE_LARGE.$this->extension;
		$this->nom_thumb = $this->page.Parametres::EXTENSION_IMAGE_THUMB.$this->extension;
		$this->chemin_thumb = $chemin.Parametres::DOSSIER_IMAGES.$this->nom_thumb;
	}

	/**
	 * Détermine si une image est active
	 *
	 * @return     boolean  True si l'images est active, False sinon.
	 */
	public function isImageActive() {
		return $this->erreur == 0;
	}

	/**
	 * Donne le chemin de l'image contenu dans l'ebook
	 *
	 * @return     string  L'adresse de l'image
	 */
	public function getCheminImage() {
		return $this->chemin;
	}

	/**
	 * Donne le nom de la vignette correspondant à l'image
	 *
	 * @return     string  Le nom de la vignette
	 */
	public function getNomThumb() {
		return $this->nom_thumb;
	}

	/**
	 * Donne le numéro de page correspondant à l'image
	 *
	 * @return     integer  Le numéro de page
	 */
	public function getPage() {
		return $this->page;
	}
}