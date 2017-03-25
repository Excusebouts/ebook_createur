<?php

require_once('ebook.php');
require_once('session.php');

if(!empty($_POST[Parametres::SERVICE_CONNEXION])) {
	$session = new Session($_POST[Parametres::SESSION_IDENTIFIANT],$_POST[Parametres::SESSION_MOT_DE_PASSE]);
	$session->connexion();

	if($session->estConnecte() == true) {
		Session::setSession($session);		
		header('Location:'.Parametres::CHEMIN_DASHBORD);
	} else {
		header('Location:'.Parametres::CHEMIN_CONNEXION);
	}
}

if(!empty($_POST[Parametres::SERVICE_DECONNEXION])) {
	$session = Session::getSession();
	$session->deconnexion();

	if($session->estConnecte() == true) {
		echo "Un problème est survenu lors de la déconnexion";
	} else {
		header('Location:'.Parametres::CHEMIN_CONNEXION);
	}
}

if(!empty($_POST[Parametres::SERVICE_CREATION])) {		
	$ebook = new Ebook($_POST["titre"],$_FILES);
	$ebook->creerEbook();	
	
	header("Location: ".Parametres::CHEMIN_DASHBORD.'?'.Parametres::SERVICE_EBOOK_CREE.'=true&'.Parametres::SERVICE_EBOOK_CREE_NOM.'='.$ebook->getTitre());
}

if(!empty($_POST[Parametres::SERVICE_ZIP])) {
	verificationConnexion();	
	$ebook_a_zipper = new Ebook($_POST[Parametres::SERVICE_ZIP]);
	if($ebook_a_zipper->zippageEbook()) {	
		$chemin_zip = $ebook_a_zipper->getCheminZip();	

		header('Content-type: application/zip');
		header('Content-Transfer-Encoding: fichier'); 
		header('Content-Disposition: attachment; filename="'.$chemin_zip.'"'); 
		header('Content-Length: '.filesize($chemin_zip)); 
		header('Pragma: no-cache'); 
		header('Expires: 0');
		header('Location:'.$ebook_a_zipper->getCheminZipSession(Session::getSession(),$_SERVER['HTTP_HOST']));
	} else {
		echo "Impossible de générer le zip.";
	}
}

if(!empty($_POST[Parametres::SERVICE_PDF])) {
	verificationConnexion();
	$ebook_a_lire = new Ebook($_POST[Parametres::SERVICE_PDF]);	

	header('Location: '.$ebook_a_lire->getPDFSession(Session::getSession(),$_SERVER['HTTP_HOST']));
}

if(!empty($_POST[Parametres::SERVICE_SUPPRESSION])) {
	$ebook_a_supprimer = new Ebook($_POST[Parametres::SERVICE_SUPPRESSION]);
	$ebook_a_supprimer->supprimerEbook();	

	header("Location:".Parametres::CHEMIN_DASHBORD);
}

if(!empty($_POST[Parametres::SERVICE_LECTURE_EBOOK])) {
	verificationConnexion();
	$ebook_a_lire = new Ebook($_POST[Parametres::SERVICE_LECTURE_EBOOK]);	

	header('Location: '.$ebook_a_lire->getIndexSession(Session::getSession(),$_SERVER['HTTP_HOST']));
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

function verificationConnexion() {
	if(Session::verificationSession() == false) {		
		header('Location:'.Parametres::CHEMIN_CONNEXION);	
	} 
}

?>