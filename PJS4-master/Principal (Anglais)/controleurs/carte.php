<?php 

function lancercarte(){
    session_start();
    $s =""; 
 require ("./vues/carte.php");
}

function ajoutListe(){
    require ("./modeles/carte.php");
    $s ="";
    if(AjoutFavori()){
        $s="Votre élément est maintenant en favoris";
    }
    else {
        $s="L'ajout de cet élémenent n'a pas pu aboutir";
    }
    require("./vues/carte.php");

}

function listefav(){
    require("./modeles/listefav.php");
}

function carteAmi(){
    require("./vues/carteAmi.php");
}

function listefavAmi(){
    require("./modeles/listefavAmi.php");
}

function retirerfav(){
    require ("./modeles/carte.php");
    retirerliste();
    $s="Votre élément à bien été retiré de votre liste.";
    require("./vues/carte.php");
}

?>