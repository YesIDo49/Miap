<?php 
    
function affins(){
    $errins=0;
    require ("./vues/inscription.php");
}
function affmodele(){
    $errins=0;
    require ("./modeles/inscription.php");
    if(!postmodele()){
        $errins=1;
        require ("./vues/inscription.php");
    }     
}


?>