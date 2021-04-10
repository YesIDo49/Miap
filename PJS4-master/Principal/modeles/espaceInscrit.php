<?php
session_start();
$ami1= $_SESSION["id"];

function actionsDem(){
    $idami = isset($_POST['idami'])?($_POST['idami']):'';
    $valide='O';
    $invalide='N';
    $ami1 = $_SESSION["id"];
    if(isset($_POST['acceptation'])) {
        acceptDem($idami,$valide,$ami1);
    }    
    elseif(isset($_POST['refus'])) {
        refusDem($idami,$invalide,$ami1);
    }
}

function InviterAmi(){
    $valide = "O";
    $ami1 = $_SESSION["id"];
    if (!getAmibyMail()){
        return false;
    }
    else{
        sendInvit($ami1 , getAmibyMail(), $valide);
        return true;        
    }

}

function sendInvit($ami1,$ami2,$demande){
    require ("./connect.php");

	$requete = "INSERT INTO ami (ami1,ami2,demande) VALUES (:ami1, :ami2, :demande)";
    try {
        $commande = $pdo->prepare($requete);
		$commande->bindParam(':ami1', $ami1, PDO::PARAM_STR);
		$commande->bindParam(':ami2', $ami2, PDO::PARAM_STR);
		$commande->bindParam(':demande', $demande, PDO::PARAM_STR);
		$commande->execute();		
		return true;
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }
}

function getAmibyMail(){
    require ("./connect.php");
    $mailAmi = isset($_POST['mailAmi'])?($_POST['mailAmi']):'';
    //echo($mailAmi);
    $requete = "SELECT * FROM inscrit" ;
    try {
        $stmt = $pdo->query($requete);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }	
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :  
        if ($row['mail'] == $mailAmi) :
            return $ami2 = $row["id_ins"];
		endif;
	endwhile;
    return false;
}

function refusDem($idami, $invalide, $ami1){
    require ("./connect.php");
	$sql = "UPDATE ami SET rep_dem = :invalide where ami2 = :ami1 and ami1=:idami";
    try {
        $commande = $pdo->prepare($sql);
		$commande->bindParam(':invalide', $invalide, PDO::PARAM_STR);
        $commande->bindParam(':idami', $idami, PDO::PARAM_INT);
        $commande->bindParam(':ami1', $ami1, PDO::PARAM_INT);
		$commande->execute();		
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }	
}

function acceptDem($idami, $valide, $ami1){
    require ("./connect.php");
	$sql = "UPDATE ami SET rep_dem = :valide where ami2 = :ami1 and ami1=:idami";
    try {
        $commande = $pdo->prepare($sql);
		$commande->bindParam(':valide', $valide, PDO::PARAM_STR);
        $commande->bindParam(':idami', $idami, PDO::PARAM_INT);
        $commande->bindParam(':ami1', $ami1, PDO::PARAM_INT);
		$commande->execute();		
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }	
}

function getAmisPartA(){
    require ("./connect.php");
    $id = $_SESSION["id"];
	$requete = "SELECT * FROM ami, inscrit where ami1 = " . $id . " and rep_dem='O' and ami2=id_ins";
    try {
        $stmtAmiA = $pdo->query($requete);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }	
    return $stmtAmiA;
}

function getAmisPartB(){
    require ("./connect.php");
    $id = $_SESSION["id"];
	$requete = "SELECT * FROM ami, inscrit where ami2 = " . $id . " and rep_dem='O' and ami1=id_ins";
    try {
        $stmtAmiB = $pdo->query($requete);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }	
    return $stmtAmiB;
}

function getDem(){
    require ("./connect.php");
    $id = $_SESSION["id"];
	$requete = "SELECT * FROM ami, inscrit where ami2= " . $id . " and demande='O' and rep_dem is null and ami1=id_ins ";
    try {
        $stmtDem = $pdo->query($requete);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }	
    return $stmtDem;
}
;

?>