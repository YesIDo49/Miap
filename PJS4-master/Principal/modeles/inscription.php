
<?php

function postmodele(){
	$nom=  isset($_POST['nom'])?($_POST['nom']):'';
	$mdp=  isset($_POST['mdp'])?($_POST['mdp']):'';
	$mail=  isset($_POST['mail'])?($_POST['mail']):'';
    $msg='';

	if  (count($_POST)==0){
		echo '<script type="text/javascript">alert("Veuillez remplir le formulaire")</script>';
	}
	if (!verifchamps($nom, $mail,$mdp)){
		return false;
	}
    else{
		ajouterpersonne(trim($nom),trim($mdp),trim($mail));
		$delai = 1;
		$url = 'index.php?controle=connexion&action=connexion';
		header("Refresh: $delai;url=$url");        
		return true;        
	}
}

        

function ajouterpersonne($nom,$mdp,$mail) {
    require ("./connect.php");
    $mdp = sha1($mdp);
	$sql="INSERT INTO inscrit (nom,mail,mdp) VALUES (:nom, :mail, :mdp)"; 
	try {
		$commande = $pdo->prepare($sql);
		$commande->bindParam(':nom', $nom, PDO::PARAM_STR);
		$commande->bindParam(':mdp', $mdp, PDO::PARAM_STR);
		$commande->bindParam(':mail', $mail, PDO::PARAM_STR);
		$commande->execute();		
		return true;
	}
		catch (PDOException $e) {
			echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	
	}
	
}

function valideMail($mail) {
    return !preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $mail) ? FALSE : TRUE;
}

function verifchamps($nom, $mail,$mdp) {
	if(strlen ( $mdp ) < 6 ){
		return false;
	}
	if(!ctype_alnum (trim($nom))){
		return false;
	}
	if(strlen ( $nom ) > 20){
		return false;
	}
	if(empty($nom)){
		return false;
	}
	if(empty($mail)){
		return false;
	}
	if(empty($mdp)){
		return false;
	}
	if(!valideMail($mail)){
		return false;
	}

	return true;
}
		
?>

