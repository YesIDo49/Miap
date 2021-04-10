<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos amis | MIAP</title>
    <link rel="icon" type="image/png" href="./image/LogoPng.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
          integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
          crossorigin="" />
    <!-- Bibliothèque Javascript Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlx5BQ52Nb7AAACUxLJ8ioc4Ht3syAwgU&libraries=places"></script>
    <!-- Javascript Material Design -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./vues/css/styleLogin.css">
    <link rel="stylesheet" type="text/css" href="styles/phone.css" media="only screen and (max-width: 767px)" />

    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</head>
<body>
<header>
    <!-- header inner -->
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo"> <a href="index.html"><img src="./image/miap_fond.png" alt="Logo" class="img-fluid" id=logo></a></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                    <div class="menu-area">
                        <div class="limit-box">
                            <nav class="main-menu">
                                <ul class="menu-area-main">
                                    <li> <a href="./blog.html"> Blog</a> </li>
                                    <li> <a href="./equipe.html">L'équipe</a> </li>
                                    <li> <a href="./aide.html">Contactez-nous</a> </li>
                                    <li>
                                        <form name="x" action="./index.php?controle=carte&action=lancerCarte" method="post">
                                            <button type="submit" class="btn-link nav-link">Votre carte</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form name="x" action="./index.php?controle=accueil&action=deco" method="post">
                                            <button type="submit" class="btn-link nav-link">Se Déconnecter</button>
                                        </form>
                                    </li>
                                    <li></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end header inner -->
</header>
<div class="contenu container">
    <div class="row">
        <h3 class="mx-auto"> Vos Amis</h3>
    </div> <hr>
    <div class="row pl-5">
        <form name="x" action="./index.php?controle=espaceInscrit&action=InvitAmi" method="post">
            Ajoutez un ami avec son adresse mail : <br>
            <input id="input-ami" type="text" name="mailAmi" value="" placeholder="Saisissez son adresse mail ici" >
            <br>
            <button class="btn-ami" type="submit" class="btn-link nav-link">Ajouter cet ami</button>
        </form>
    </div>
    <div class="row pt-5 pl-5">
        Votre Liste d'amis : <br>
    </div>
    <?php
    while($row1 = $stmtAmiA->fetch(PDO::FETCH_ASSOC)) :
        echo("<div class='row pl-5'>");
        echo($row1["nom"]);
        echo("<form action='./index.php?controle=carte&action=carteAmi' method='post' class='pl-2'>
                        <input class='disnone' type='text' name='idami' value= ".  ($row1['ami2']) . " readonly>
                        <input class='disnone' type='text' name='nomami' value= ".  ($row1['nom']) . " readonly>
                        <button type='submit' id='voir' class='btn-link btnamis'>Voir sa carte</button>
                        </form>");
        echo("<br> </div>");
    endwhile;

    while($row2 = $stmtAmiB->fetch(PDO::FETCH_ASSOC)) :
        echo("<div class='row pl-5'>");
        echo($row2["nom"]);
        echo("<form action='./index.php?controle=carte&action=carteAmi' method='post' class='pl-2'>
                        <input class='disnone' type='text' name='idami' value= ".  ($row2['ami1']) . " readonly>  
                        <input class='disnone' id='text-ami' type='text' name='nomami' value= ".  ($row2['nom']) . " readonly>
                        <button type='submit' id='voir' class='btn-link btnamis'>Voir sa carte</button>
                        </form>");
        echo("<br> </div>");
    endwhile;
    ?>

    <div class="row pt-3 pl-5">
        Vos demandes d'amis reçu : <br>
    </div>
    <?php
    while($row = $stmtDem->fetch(PDO::FETCH_ASSOC)) :
        echo("<div class='row pl-5'>");
        //echo($row["ami1"]);
        echo("Nom : ");
        echo($row["nom"]);
        echo(" ");

        echo("<form action='./index.php?controle=espaceInscrit&action=accepterDem' method='post' class='pl-2'>
                        <input class='disnone' id='text-ami' type='text' name='idami' value= ".  ($row['ami1']) . " readonly>  
                        <button id='voir' name='acceptation' type='submit' class='btn-link'>Accepter</button>
                        <button id='voir' name='refus' type='submit' class='btn-link'>Refuser</button>
                    </form>");
        echo("<br> </div>");
    endwhile;
    ?>
</div>

</div>
<div id="scroll_to_top">
    <a href="#top"><img src="image/scroll.png" alt="Retourner en haut" /></a>
</div>

<footer>
    <div class="footer pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 width">
                    <div class="address">
                        <h3>Adresse</h3>
                        <p><img src="icon/3.png">143 Avenue de Versailles, 75016 Paris</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 width">
                    <div class="address">
                        <h3>Menu</h3>
                        <p><a href="./blog.html">Blog</a></p>
                        <p><a href="./equipe.html">A propos</a></p>
                        <p><a href="./aide.html">Aide & Contact</a></p>
                        <p><a href="#">Connexion</a></p>
                        <p><a href="#">Inscription</a></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 width">
                    <div class="address">
                        <h3>Réseaux Sociaux </h3>
                        <div class="contant_icon">
                            <!--<li><img src="icon/fb.png" alt="icon"/></li>-->
                            <p><a href="https://twitter.com/Miap09882942"><img src="icon/tw.png" alt="icon"/></a>
                                @MiapO9882942</p>
                            <br>
                            <!--<li><img src="icon/lin (2).png" alt="icon"/></li>-->
                            <p><a href="https://www.instagram.com/miapies_world/"><img src="icon/instagram.png" alt="icon"/></a>
                                @miapies_world</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Javascript files-->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.0.0.min.js"></script>
<script src="js/plugin.js"></script>
<!-- sidebar -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/custom.js"></script>
<script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function(){
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });

        $(".zoom").hover(function(){

            $(this).addClass('transition');
        }, function(){

            $(this).removeClass('transition');
        });
    });

</script>
</body>
</html>