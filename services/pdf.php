<?php

require_once('tcpdf/tcpdf.php');
require_once('parametres.php');
require_once('image.php');

/**
 * Classe permettant la génération d'un PDF de l'ebook
 *
 * version     : 1.0.0
 * @author     Vibey Cédric (cedric.vibey@gmail.com)
 */
class Pdf {

	// Le tableau des images de l'ebook
	protected $images;

	// Le titre du PDF
	protected $titre;

	// Le chemin du PDF
	protected $chemin_pdf;

	// L'objet permettant la génération d'un PDF
	protected $pdf;

	/**
	 * Constructeur par défaut du générateur de PDF
	 *
	 * @param      array  $images  Le tableau d'images de l'ebook à mettre dans le PDF
	 * @param      string  $chemin  Le chemin de l'ebook
	 * @param      string  $titre   Le titre de l'ebook
	 */
	public function __construct($images = null, $chemin, $titre) {		
		$this->images = $images;
		$this->chemin_pdf = $chemin.Parametres::FICHIER_PDF;
		$this->titre = $titre;
		$this->pdf = null;
	}

	/**
	 * Génère un PDF correspondant à l'ebook
	 */
	public function genererPDF() {

		$this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->parametrage();

		foreach($this->images as $image) {
			$this->nouvellePage($image);
		}

		$this->pdf->Output($this->chemin_pdf, 'F');
	}

	/**
	 * Paramètre le PDF
	 */
	private function parametrage() {
		
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor(Parametres::PDF_AUTEUR);
		$this->pdf->SetTitle($this->titre);
		$this->pdf->SetSubject(Parametres::PDF_SUJET);	
		
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->pdf->SetHeaderMargin(Parametres::PDF_HEADER_MARGIN);
		$this->pdf->SetFooterMargin(Parametres::PDF_FOOTER_MARGIN);

	
		$this->pdf->setPrintFooter(false);
		
		$this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);		
	}

	/**
	 * Créé une nouvelle page dans le PDF
	 *
	 * @param      image  $image  L'image à ajouter dans la nouvelle page
	 */
	private function nouvellePage($image) {
		$this->pdf->AddPage();		
		$bMargin = $this->pdf->getBreakMargin();		
		$auto_page_break = $this->pdf->getAutoPageBreak();		
		$this->pdf->SetAutoPageBreak(false, 0);		
		$img_file = $image->getCheminImage();
		$this->pdf->Image($img_file, Parametres::PDF_X, Parametres::PDF_Y, Parametres::PDF_LARGEUR, Parametres::PDF_HAUTEUR, '', '', '', false, Parametres::PDF_RESOLUTION, '', false, false, 0);
		$this->pdf->SetAutoPageBreak($auto_page_break, $bMargin);	
		$this->pdf->setPageMark();		
	}

	/**
	 * Donne le chemin du PDF.
	 *
	 * @return     string  L'adresse du PDF
	 */
	public function getCheminPDF() {
		return $this->chemin_pdf;
	}
}

?>