<?php

require_once('ebook.php');

if(isset($_POST["titre"]) /*&& !isset($_FILES['page0']) && !isset($_FILES['page1']) && !isset($_FILES['page2']) && !isset($_FILES['page3'])*/) {
	
	$ebook = new Ebook($_POST["titre"],$_FILES);
	$ebook->creerEbook();	
	
	//header("Location: ".$ebook->getIndex());
}


?>