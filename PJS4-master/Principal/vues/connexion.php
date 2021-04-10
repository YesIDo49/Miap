<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="./vues/css/styleLogin.css">
    <link rel="stylesheet" type="text/css" href="styles/phone.css" media="only screen and (max-width: 767px)" />

    <title>Se Connecter</title>
    <link rel="icon" type="image/png" href="./image/LogoPng.png">
</head>
<body>
<a href="#"><img src="./vues/img/logo2.png" alt="miap" class=" img-fluid logocoins"></a>
<div class="espace"></div>
<div class="centre">
    <div class="connect sm-col-12" >
        <span class="Hdl"> De Retour ? <br> Connectez-vous ! </span>
        <form action="index.php?controle=connexion&action=reqmodele" method="post">
            </br>
            Adresse E-mail     <br/>
            <input  name="mail"     type="text"
                    value= " " />
            <br/><br/>
            Mot de passe    <br/>
            <input  type="password"     name="mdp"
                    value= " " />             <br/><br/>
            <input id="connecter" type= "submit"  value="Connexion" >
        </form> <br>
        <?php
        if($errco==1){
            echo("Votre identifiant ou mot de passe est incorrect. <br>");
        }
        ?>
        <hr>
        <span class="pt-3"> Pas encore inscrit ? </span> <br>
        <form class="form-co-ins" name="x" action="index.php?controle=inscription&action=affins" method="post">
            <button id="inscrire" type="submit" class="btn-link nav-link">S'inscrire</button>
        </form>
        <!-- <a href="./Inscription.php"> S'inscrire </a> -->
        <br> <hr>
        <span><button id="return">
                <a href="./index.html">Retour à l'accueil</a>
    </button> </span>

    </div>

</div>


</body>
</html>