<?php

class Writer {

	protected $chemin;

	public function __construct($chemin) {
		$this->chemin = $chemin;
	}	

	public function ecrireFichier() {		
		$fichier = fopen($this->chemin,'r+');
		$fichier_tmp = fopen($this->chemin.'_tmp','w+');
		$contenuFichier = "";

		if($fichier) {
			while (($buffer = fgets($fichier)) !== false) {
				$contenuFichier .= $buffer;

				if(strstr($buffer,'template_ajout_titre')) {
					$contenuFichier .= '<title>Ebook Dal\'Alu</title>';
				}

				if(strstr($buffer,'template_ajout_thumbnails')) {
					$contenuFichier .= '<li class="i"><img src="pages/1-thumb.jpg" width="76" height="100" class="page-1"><span>1</span></li>';
				}

				if(strstr($buffer,'template_ajout_nbpages')) {
					$contenuFichier .= 'pages: 4,';
				}
				
		    }

		    fputs($fichier_tmp,$contenuFichier,strlen($contenuFichier));
		}
		
		fclose($fichier);
		fclose($fichier_tmp);
	}
}

?>