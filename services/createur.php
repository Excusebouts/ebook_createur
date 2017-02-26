<?php

require_once('ebook.php');

if(isset($_POST["titre"])) {
	$ebook = new Ebook($_POST["titre"]);
	$ebook->creerEbook();	
	
	header("Location: ".$ebook->getIndex());
}


?>