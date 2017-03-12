<?php

require_once('parametres.php');

class Image {

	protected $page;

	protected $nom_upload;

	protected $type;

	protected $extension;

	protected $chemin_temporaire;

	protected $chemin;

	protected $chemin_large;

	protected $nom_thumb;

	protected $chemin_thumb;

	protected $erreur;

	protected $taille;

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

	public function genererImage() {
		if($this->isImageActive()) {
			if(move_uploaded_file($this->chemin_temporaire,$this->chemin)) {
				copy($this->chemin, $this->chemin_large);
				copy($this->chemin, $this->chemin_thumb);				
			} 
		}
	}

	public function genererChemin($chemin) {
		$this->chemin = $chemin.Parametres::DOSSIER_IMAGES.$this->page.$this->extension;
		$this->chemin_large = $chemin.Parametres::DOSSIER_IMAGES.$this->page.Parametres::EXTENSION_IMAGE_LARGE.$this->extension;
		$this->nom_thumb = $this->page.Parametres::EXTENSION_IMAGE_THUMB.$this->extension;
		$this->chemin_thumb = $chemin.Parametres::DOSSIER_IMAGES.$this->nom_thumb;
	}

	public function isImageActive() {
		return $this->erreur == 0;
	}

	public function getNomThumb() {
		return $this->nom_thumb;
	}

	public function getPage() {
		return $this->page;
	}
}