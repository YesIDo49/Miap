<?php 

//hypothèse 2 paramètres d'entrée, controle et action, avec l'url de index.php
// exemple : index.php?controle=c1&action=a12

if (isset($_GET['controle']) & isset($_GET['action'])) {
 	$controle = $_GET['controle'];
	$action= $_GET['action'];
	}
else {  // absence de paramètres : prévoir des valeurs par défaut
	$controle = "accueil";
    $action= "af"; // Lance la page d'accueil sans aucun service 
}

//inclure le fichier php de contrôle 
//et lancer la fonction-action issue de ce fichier.	
	//require ('./controleurs/accueil.php');
    require ('./controleurs/' . $controle . '.php');   
	$action (); 

?>