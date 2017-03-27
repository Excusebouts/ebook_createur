<?php

/**
 * Classe statique contenant les paramètres de l'application ebook
 *
 * version     : 1.0.0
 * @author     Vibey Cédric (cedric.vibey@gmail.com)
 */
class Parametres {

	const BDD_URL = "localhost";

	const BDD_NOM = "ebook_createur";

	const BDD_UTILISATEUR = "root";

	const BDD_PASS = "123456";

	const URL_HTTP = "http://";

	const DOSSIER_EBOOK = "..".Parametres::DOSSIER_EBOOK_NOM;

	const DOSSIER_EBOOK_NOM = "/ebook/"; 

	const DOSSIER_TEMPLATE = "../template/";

	const DOSSIER_IMAGES = "pages/";

	const CHEMIN_DASHBORD = "../accueil.php";

	const CHEMIN_CONNEXION = "../index.php";

	const INDEX_EBOOK = "ebook.html";

	const INDEX_EBOOK_TEMPLATE = "ebook_template.html";

	const EXTENSION_IMAGE_LARGE = "-large";

	const EXTENSION_IMAGE_THUMB = "-thumb";

	const EXTENSION_ZIP = ".zip";

	const FICHIER_PDF = "PDF.pdf";

	const PDF_AUTEUR = "Dal'Alu";

	const PDF_SUJET = "ebook";

	const PDF_X = "0";

	const PDF_Y = "0";

	const PDF_HAUTEUR = "297";

	const PDF_LARGEUR = "210";

	const PDF_RESOLUTION = "300";

	const PDF_HEADER_MARGIN = "0";

	const PDF_FOOTER_MARGIN = "0";

	const SESSION_VARIABLE = "session";

	const SESSION_IDENTIFIANT = "pseudo";

	const SESSION_MOT_DE_PASSE = "mot_de_passe";

	const SERVICE_LECTURE_EBOOK = "lire_ebook";

	const SERVICE_EBOOK_CREE = "ebook_create";

	const SERVICE_EBOOK_CREE_NOM = "ebook_create_name";

	const SERVICE_CONNEXION = "connexion";

	const SERVICE_DECONNEXION = "deconnexion";

	const SERVICE_SUPPRESSION = "suppression";

	const SERVICE_CREATION = "creation";

	const SERVICE_ZIP = "zip";

	const SERVICE_PDF = "pdf";
}

?>