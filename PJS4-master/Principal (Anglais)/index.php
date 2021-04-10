<?php 

//hypothesis 2 entry parameters, control and action, with the url of index.php
// example : index.php?controle=c1&action=a12

if (isset($_GET['controle']) & isset($_GET['action'])) {
 	$controle = $_GET['controle'];
	$action= $_GET['action'];
	}
else {  // absence of parameters plan default values
	$controle = "accueil";
    $action= "af"; // launches the home page without any service
}

//includes the controlling php file
//and launches the function-action issued from this file
	//require ('./controleurs/accueil.php');
    require ('./controleurs/' . $controle . '.php');   
	$action (); 

?>