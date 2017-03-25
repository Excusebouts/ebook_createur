<?php

require_once('tcpdf/tcpdf.php');
require_once('parametres.php');
require_once('image.php');

class Pdf {

	protected $images;

	protected $titre;

	protected $chemin_pdf;

	protected $pdf;

	public function __construct($images = null, $chemin, $titre) {		
		$this->images = $images;
		$this->chemin_pdf = $chemin.Parametres::FICHIER_PDF;
		$this->titre = $titre;
		$this->pdf = null;
	}

	public function genererPDF() {

		$this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->parametrage();

		foreach($this->images as $image) {
			$this->nouvellePage($image);
		}

		$this->pdf->Output($this->chemin_pdf, 'F');
	}

	private function parametrage() {
		
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor(Parametres::PDF_AUTEUR);
		$this->pdf->SetTitle($this->titre);
		$this->pdf->SetSubject(Parametres::PDF_SUJET);	
		
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->pdf->SetHeaderMargin(Parametres::PDF_HEADER_MARGIN);
		$this->pdf->SetFooterMargin(Parametres::PDF_FOOTER_MARGIN);

		// remove default footer
		$this->pdf->setPrintFooter(false);

		// set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);		
	}

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

	public function getCheminPDF() {
		return $this->chemin_pdf;
	}
}

?>