<?php
session_start();
    $idami=  isset($_POST['idami'])?($_POST['idami']):'';
    require ("./connect.php");
    $return_array = array();
    $data1 =array();
    //echo($id);
    //$statement = $pdo->prepare("SELECT * FROM note N, lieu L where N.inscrit =" . $_SESSION['id'] . "and N.lieu = L.id_lieu;" );
    //  $statement = $pdo->prepare("SELECT * FROM note, lieu where inscrit= 1 and lieu=id_lieu" );
    $statement = $pdo->prepare("SELECT * FROM note, lieu where inscrit= " . $idami . " and lieu=id_lieu and favoris='O'" );

    $statement->execute();

    $data1= $statement->fetchAll( PDO::FETCH_ASSOC );

    $return_array["liste"] = $data1;
    echo json_encode($return_array); 
?>