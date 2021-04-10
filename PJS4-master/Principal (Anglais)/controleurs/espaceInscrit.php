<?php 
function affEspace(){
    reqmodEs();
    getaff();
}

function InvitAmi(){
    $s ="";
    reqmodEs();
    if (InviterAmi()){
        $s= "Votre invitation à été envoyé";
    }
    else{
        $s= "Votre invitation n'a pas pu aboutir";
    }
    getaff();
}

function reqmodEs(){
    require ("./modeles/espaceInscrit.php");
}

function getaff(){
    $stmtAmiA=getAmisPartA();
    $stmtAmiB=getAmisPartB();
    $stmtDem=getDem();    
    require ("./vues/espaceInscrit.php");
}

function accepterDem(){
    reqmodEs();
    actionsDem();
    getaff();
}
?>