<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./vues/css/styleLogin.css">
    <link rel="stylesheet" type="text/css" href="./vues/css/phone.css" media="only screen and (max-width: 767px)" />
    <title>Inscription</title>
    <link rel="icon" type="image/png" href="./image/LogoPng.png">
    <link rel="icon" type="image/png" href="./image/LogoPng.png">
</head>
<body>
<a href="#"><img src="./vues/img/logo2.png" alt="miap" class=" img-fluid logocoins"></a>
<div class="espace"></div>
<div class="centre">
    <div class="connect sm-col-12">
        <span class="Hdl"> Inscription </span>
        <form action="index.php?controle=inscription&action=affmodele" method="post">
            </br>
            Nom     <br/>
            <input 	name="nom" 	type="text"
                      value= " " />
            <br/><br/>
            Adresse E-mail     <br/>
            <input 	name="mail" 	type="text"
                      value= " " />
            <br/><br/>
            Mot de passe (6 caractères minimum)<br/>
            <input 	type="password" 	name="mdp"
                      value= " " />             <br/><br/>
            <input id="connecter" type= "submit"  value="S'inscrire" >
        </form> <br>
        <?php
        if($errins==1){
            echo("Vos champs sont mal remplis <br>");
        }
        ?>
        <hr>
        <span class="pt-3"> Vous avez déjà un compte ? </span> <br>
        <form class="form-co-ins" name="x" action="index.php?controle=connexion&action=connexion" method="post">
            <button id="connecter" type="submit" class="btn-link nav-link">Connectez vous</button>
        </form>
        <!-- <a href="./Connexion.php"> Connectez-vous ! </a> -->
        <br> <hr>
        <span><button id="return">
                <a href="./index.html">Retour à l'accueil</a>
        </button></span>
    </div>
</div>

</body>
</html>