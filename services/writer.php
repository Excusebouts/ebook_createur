<?php

require_once('template.php');
require_once('image.php');

class Writer {

	protected $chemin_fichier_template;

	protected $chemin_fichier;

	protected $titre;

	protected $images;

	public function __construct($chemin_fichier_template, $chemin_fichier, $titre, $images) {
		$this->chemin_fichier_template = $chemin_fichier_template;
		$this->chemin_fichier = $chemin_fichier;
		$this->titre = $titre;
		$this->images = $images;
	}	

	public function ecrireFichier() {		
		$fichier_template = fopen($this->chemin_fichier_template,'r+');
		$fichier = fopen($this->chemin_fichier,'w+');
		$contenus_fichier = "";

		if($fichier_template) {
			while (($buffer = fgets($fichier_template)) !== false) {
				$contenus_fichier .= $buffer;

				if(strstr($buffer,Template::TEMPLATE_WRITER_AJOUT_TITRE)) {
					$contenus_fichier .= $this->genererTitre();
				}

				if(strstr($buffer,Template::TEMPLATE_WRITER_AJOUT_THUMBNAILS)) {
					$contenus_fichier .= $this->genererThumbnails();
				}

				if(strstr($buffer,Template::TEMPLATE_WRITER_AJOUT_NB_PAGES)) {
					$contenus_fichier .= $this->genererNbPages();
				}
				
		    }

		    fputs($fichier,$contenus_fichier,strlen($contenus_fichier));
		}
		
		fclose($fichier);
		fclose($fichier_template);
	}

	private function genererTitre() {
		$chaine_tmp = "";

		$chaine_tmp .= Template::TEMPLATE_WRITER_TITRE_BALISE;
		$chaine_tmp .= $this->titre;
		$chaine_tmp .= Template::TEMPLATE_WRITER_TITRE_BALISE_2;		

		return $chaine_tmp;
	}	

	private function genererThumbnails() {
		$chaine_tmp = "";

		$chaine_tmp .= Template::TEMPLATE_WRITER_THUMBNAILS_DEBUT;		

		$i = 0;
		while($i < sizeof($this->images)) {
			if($i == 0 || $i == sizeof($this->images)-1) {
				$chaine_tmp .= $this->genererImagesThumbnails(Template::TEMPLATE_WRITER_THUMBNAILS_DEBUT_LI_CLASS_I,$this->images[$i]);
				$i++;
			} else {
				$i_tmp = $i + 1;
				if($i_tmp == sizeof($this->images)-1) {
					$chaine_tmp .= $this->genererImagesThumbnails(Template::TEMPLATE_WRITER_THUMBNAILS_DEBUT_LI_CLASS_I,$this->images[$i],$this->images[$i_tmp]);
				} else {
					$chaine_tmp .= $this->genererImagesThumbnails(Template::TEMPLATE_WRITER_THUMBNAILS_DEBUT_LI_CLASS_D,$this->images[$i],$this->images[$i_tmp]);
				}
				
				$i = $i + 2;
			}
		}

		$chaine_tmp .= Template::TEMPLATE_WRITER_THUMBNAILS_FIN;		

		return $chaine_tmp;
	}

	private function genererImageThumbnails($image) {
		$chaine_tmp = "";

		$chaine_tmp .= Template::TEMPLATE_WRITER_THUMBNAILS_IMG_PARTIE_1;
		$chaine_tmp .= $image->getNomThumb();
		$chaine_tmp .= Template::TEMPLATE_WRITER_THUMBNAILS_IMG_PARTIE_2;
		$chaine_tmp .= $image->getPage();
		$chaine_tmp .= Template::TEMPLATE_WRITER_THUMBNAILS_IMG_PARTIE_3;		

		return $chaine_tmp;
	}

	private function genererImagesThumbnails($li, $image, $image_optionnel = null) {
		$chaine_tmp = "";

		$chaine_tmp .= $li;		
		$chaine_tmp .= $this->genererImageThumbnails($image);

		if($image_optionnel != null) {			
			$chaine_tmp .= $this->genererImageThumbnails($image_optionnel);
		}

		$chaine_tmp .= Template::TEMPLATE_WRITER_THUMBNAILS_SPAN_DEBUT;
		$chaine_tmp .= $image->getPage();

		if($image_optionnel != null) {
			$chaine_tmp .= Template::TEMPLATE_WRITER_THUMBNAILS_SPAN_SEPARATEUR;
			$chaine_tmp .= $image_optionnel->getPage();
		}

		$chaine_tmp .= Template::TEMPLATE_WRITER_THUMBNAILS_SPAN_FIN;		
		$chaine_tmp .= Template::TEMPLATE_WRITER_THUMBNAILS_FIN_LI_CLASS;	

		return $chaine_tmp;
	}

	private function genererNbPages() {
		$chaine_tmp = "";

		$chaine_tmp .= Template::TEMPLATE_WRITER_NB_PAGES_PARTIE_1;
		$chaine_tmp .= sizeof($this->images);
		$chaine_tmp .= Template::TEMPLATE_WRITER_NB_PAGES_PARTIE_2;

		return $chaine_tmp;
	}
}

?>