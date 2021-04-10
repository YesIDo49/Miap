<?php
session_start();

function af(){
    header("Refresh: 0;url=./index.html");
    //require ("./vues/accueil.php");
}

function deco(){
    session_destroy();  
    af();
}

?>