<?php

require_once('ebook.php');

if(!empty($_POST[Parametres::SERVICE_CREATION])) {		
	$ebook = new Ebook($_POST["titre"],$_FILES);
	$ebook->creerEbook();	
	
	header("Location: ".$ebook->getIndex());
}

if(!empty($_POST[Parametres::SERVICE_ZIP])) {
	$ebook_a_zipper = new Ebook($_POST[Parametres::SERVICE_ZIP]);
	if($ebook_a_zipper->zippageEbook()) {	
		$chemin_zip = $ebook_a_zipper->getCheminZip();	
		
		header('Content-type: application/zip');
		header('Content-Transfer-Encoding: fichier'); 
		header('Content-Disposition: attachment; filename="'.$chemin_zip.'"'); 
		header('Content-Length: '.filesize($chemin_zip)); 
		header('Pragma: no-cache'); 
		header('Expires: 0');
		header("Location:".$chemin_zip);
	} else {
		echo "Impossible de générer le zip.";
	}
}

if(!empty($_POST[Parametres::SERVICE_SUPPRESSION])) {
	$ebook_a_supprimer = new Ebook($_POST[Parametres::SERVICE_SUPPRESSION]);
	$ebook_a_supprimer->supprimerEbook();	

	header("Location:".$_SERVER['HTTP_REFERER']);
}

function recupererListeEbook() {
	$liste_ebook = array();
	$chemin_ebooks = dirname(__FILE__)."/".Parametres::DOSSIER_EBOOK;

	if($tmp_liste_ebook = scandir($chemin_ebooks)) {
		if(sizeof($tmp_liste_ebook) > 2) {
			foreach($tmp_liste_ebook as $nom_ebook) {
				if(file_exists($chemin_ebooks.$nom_ebook."/".Parametres::INDEX_EBOOK)) {
					array_push($liste_ebook, new Ebook($nom_ebook));
				}
			}
		} 
	}

	return $liste_ebook;
}

?>