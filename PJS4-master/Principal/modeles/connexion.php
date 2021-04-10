<?php
session_start();


function verif(){

    require ("./connect.php");

    $mail=  isset($_POST['mail'])?($_POST['mail']):'';
    $mdp=  isset($_POST['mdp'])?($_POST['mdp']):'';
        
    $requete = "SELECT id_ins,nom,mail,mdp FROM inscrit";

    try {
        $stmt = $pdo->query($requete);
    }
    catch (PDOException $e) {
        echo utf8_encode("Echec de select : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
    }

    //azerty
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :  

        if ($row['mdp'] ==  sha1($mdp) and $row['mail'] == trim($mail)) :
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['mail'] = $row['mail'];
            $_SESSION['mdp'] = $row['mdp'];
            $_SESSION['id'] = $row['id_ins'];
            $delai = 0.0;
            $url = 'index.php?controle=carte&action=lancercarte';
            header("Refresh: $delai;url=$url"); 
            return true;
        endif;
        if ($row['mdp'] =!  sha1($mdp) or $row['mail'] =! $mail) :
            session_destroy();
            return false;
        endif;
    endwhile;
}

?>