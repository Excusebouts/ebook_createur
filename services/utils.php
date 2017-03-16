<?php

class Utils {
    
  public static function copy_dir ($dir2copy,$dir_paste) {
    // On vérifie si $dir2copy est un dossier
    if (is_dir($dir2copy)) {
   
      // Si oui, on l'ouvre
      if ($dh = opendir($dir2copy)) {     
        // On liste les dossiers et fichiers de $dir2copy
        while (($file = readdir($dh)) !== false) {
          // Si le dossier dans lequel on veut coller n'existe pas, on le créé
          if (!is_dir($dir_paste)) mkdir ($dir_paste, 0777);
   
            // S'il s'agit d'un dossier, on relance la fonction rÃ©cursive
            if(is_dir($dir2copy.$file) && $file != '..'  && $file != '.') Utils::copy_dir ( $dir2copy.$file.'/' , $dir_paste.$file.'/' );     
              // S'il sagit d'un fichier, on le copue simplement
              elseif($file != '..'  && $file != '.') copy ( $dir2copy.$file , $dir_paste.$file );                                       
          }
   
        // On ferme $dir2copy
        closedir($dh);
   
      }   
    }
  }

  public static function zipper_repertoire_recursif($nom_archive, $adr_dossier, $dossier_destination = '', $zip=null, $dossier_base = '') {    
    if($zip===null) {
      // Si l'archive n'existe toujours pas (1er passage dans la fonction, on la crée)
      $zip = new ZipArchive();
      if($zip->open($nom_archive, ZipArchive::CREATE) !== TRUE) {
        // La création de l'archive a échouée
        return false;
      }
    }
   
    if(substr($adr_dossier, -1)!='/') {
      // Si l'adresse du dossier ne se termine pas par '/', on le rajoute
      $adr_dossier .= '/';
    }
   
    if($dossier_base=="") {
      // Si $dossier_base est vide ça veut dire que l'on rentre
      // dans la fonction pour la première fois. Donc on retient
      // le tout premier dossier (le dossier racine) dans $dossier_base
      $dossier_base=$adr_dossier;
    }
   
    if(file_exists($adr_dossier)) {
      if(@$dossier = opendir($adr_dossier)) {
        while(false !== ($fichier = readdir($dossier))) {
          if($fichier != '.' && $fichier != '..') {
            if(is_dir($adr_dossier.$fichier)) {
              $zip->addEmptyDir($adr_dossier.$fichier);
              Utils::zipper_repertoire_recursif($nom_archive, $adr_dossier.$fichier, $dossier_destination, $zip, $dossier_base);
            }
            else {
              $zip->addFile($adr_dossier.$fichier);
            }
          }
        }
      }
    }
   
    if($dossier_base==$adr_dossier) {
      // On ferme la zip
      $zip->close();
     
      if($dossier_destination!='') {
        if(substr($dossier_destination, -1)!='/') {
          // Si l'adresse du dossier ne se termine pas par '/', on le rajoute
          $dossier_destination .= '/';
        }
       
        // On déplace l'archive dans le dossier voulu
        if(rename($nom_archive, $dossier_destination.$nom_archive)) {
          return true;
        }
        else {
          return false;
        }
      }
      else {
        return true;
      }
    }
  }

}
?>