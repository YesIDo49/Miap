<?php 
function connexion(){
    $errco = 0;
    require ("./vues/connexion.php");
}

function reqmodele(){
    require ("./modeles/connexion.php");
    $errco = 0; 
    verif();
    if(!verif()){
        $errco=1;
        require ("./vues/connexion.php");
    }
}


?>