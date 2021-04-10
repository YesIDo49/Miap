<?php
session_start();

function AjoutFavori(){
	$nom =  isset($_POST['infoNom'])?($_POST['infoNom']):'';
    $adresse =  isset($_POST['infoAdresse'])?($_POST['infoAdresse']):'';
	$long = isset($_POST['infoLongi'])?($_POST['infoLongi']):'';
	$lat = isset($_POST['infoLati'])?($_POST['infoLati']):'';
	$id_ins = $_SESSION['id'];
	$favoris = "O";
	$note = isset($_POST['note'])?($_POST['note']):'';
	if (!checkLieuExistant($nom,$adresse)){
		ajouterlieu($nom, $adresse, $long, $lat);
	}
	$id_lieu = getIdLieu($nom, $adresse);
	if (checkNoteExistant($id_lieu, $id_ins)){
		reajouterliste($id_lieu,$id_ins,$note);
		return true;
	}
	else {
		ajoutFavReq($id_lieu, $id_ins,$favoris,$note);
		return true;
	}
	
}

function checkLieuExistant($nom, $adresse){
	require ("./connect.php");
	$requete = "SELECT * FROM lieu";
    try {
        $stmt = $pdo->query($requete);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }	

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :  
		if ($row['nom'] == $nom  and $row['adresse'] == trim($adresse)) :
			return true;
		endif;
	endwhile;
	return false;
}

function getIdLieu($nom, $adresse){
	require ("./connect.php");
	$requete = "SELECT * FROM lieu";
    try {
        $stmt = $pdo->query($requete);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :  
		if ($row['nom'] == $nom  and $row['adresse'] == trim($adresse)) :
			return $row['id_lieu'];
		endif;
	endwhile;
	return null;
}

function ajouterlieu($nom, $adresse, $long, $lat) {
    require ("./connect.php");
	$sql="INSERT INTO lieu (nom,adresse, lng, lat) VALUES (:nom, :adresse, :long, :lat)"; 
	try {
		$commande = $pdo->prepare($sql);
		$commande->bindParam(':nom', $nom, PDO::PARAM_STR);
		$commande->bindParam(':adresse', $adresse, PDO::PARAM_STR);
		$commande->bindParam(':long', $long, PDO::PARAM_STR);
		$commande->bindParam(':lat', $lat, PDO::PARAM_STR);
		$commande->execute();		
		return true;
	}
		catch (PDOException $e) {
			echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}
}

function ajoutFavReq($id_lieu, $id_ins, $favoris, $note){
	require ("./connect.php");
	if ($note=="0"){
		$sql="INSERT INTO note (lieu,inscrit,favoris) VALUES (:id_lieu, :id_ins, :favoris)"; 
	}
	else{
		$sql="INSERT INTO note (lieu,inscrit,favoris,note) VALUES (:id_lieu, :id_ins, :favoris, :note)"; 
	}
	
	try {
		$commande = $pdo->prepare($sql);
		$commande->bindParam(':id_lieu', $id_lieu, PDO::PARAM_STR);
		$commande->bindParam(':id_ins', $id_ins, PDO::PARAM_STR);
		$commande->bindParam(':favoris', $favoris, PDO::PARAM_STR);
		if ($note=="0"){
			$commande->execute();
			return true;
		}
		$commande->bindParam(':note', $note, PDO::PARAM_STR);
		$commande->execute();
		return true;
		
	}
		catch (PDOException $e) {
			echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
		die(); // On arrête tout.
	}
}

function checkNoteExistant($id_lieu, $id_ins){
	require ("./connect.php");
	$requete = "SELECT * FROM note";
    try {
        $stmt = $pdo->query($requete);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :  
		if ($row['lieu'] == $id_lieu  and $row['inscrit'] == trim($id_ins)) :
			return true;
		endif;
	endwhile;
	return false;
}

function retirerliste(){
	$lieu =  isset($_POST['idlieu'])?($_POST['idlieu']):'';
	$idins = $_SESSION['id'];
	$invalide = 'N';
	require ("./connect.php");
	$sql = "UPDATE note SET favoris = :invalide where lieu = :lieu and inscrit=:idins";
    try {
        $commande = $pdo->prepare($sql);
		$commande->bindParam(':invalide', $invalide, PDO::PARAM_STR);
        $commande->bindParam(':lieu', $lieu, PDO::PARAM_INT);
        $commande->bindParam(':idins', $idins, PDO::PARAM_INT);
		$commande->execute();		
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }	
}

function reajouterliste($id_lieu, $id_ins, $note){
	$valide = 'O';
	require ("./connect.php");
	if ($note=="0"){
		$sql = "UPDATE note SET favoris = :valide where lieu = :id_lieu and inscrit=:id_ins";
	}
	else{
		$sql = "UPDATE note SET favoris = :valide , note = :note where lieu = :id_lieu and inscrit=:id_ins";
	}
    try {
        $commande = $pdo->prepare($sql);
		$commande->bindParam(':valide', $valide, PDO::PARAM_STR);
        $commande->bindParam(':id_lieu', $id_lieu, PDO::PARAM_INT);
        $commande->bindParam(':id_ins', $id_ins, PDO::PARAM_INT);
		if ($note!="0"){
			$commande->bindParam(':note', $note, PDO::PARAM_INT);
		}
		$commande->execute();		
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }	
}

?>