window.addEventListener("load", function () {

    var latitudeCliquee;
    var longitudeCliquee;
    var chemins = new Array();
    // =============================================== Préparation de la carte Leaflet ==================================================

    console.log("Chargement de la carte...");

    var mymap = L.map('mapid') // On initialise la <div> en tant que carte Leaflet
        .setView([48.8534, 2.3488], 13); // On paramètre la vue de la carte, d'abord latitude, puis longitude, puis le zoom
    var marker = new L.marker();
    //On importe l'image de fond
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',
        { attribution: 'Open Street Map' } // Légende en bas à droite
    ).addTo(mymap); // Ajoute l'image à la carte
    console.log("Carte chargée");

    // =================================================== Handling su clic sur la map ================================================================

    mymap.on('click', function (e) { // Handling du clic sur la carte
        $("#loader").fadeIn();
        let latitude = e.latlng.lat; // Récupération de la latitude de l'endroit du clic
        let longitude = e.latlng.lng;// Récupération de la longitude de l'endroit du clic

        chemins.forEach(element => {
            mymap.removeLayer(element);
        });
        chemins = new Array();


        latitudeCliquee = latitude;
        longitudeCliquee = longitude;

        $('#gps').html("Latitude : " + latitude + " <br>Longitude : " + longitude); // On affiche les coord GPS

        // Gestion du marker

        mymap.removeLayer(marker); // On enlève l'ancien marker
        marker = new L.marker([latitude, longitude]); // On crée le nouveau marker
        mymap.addLayer(marker); // On l'ajoute
    });

    // ========================================================= Recherche par nom de ville ===========================================================================   

    $("#search").on("click", function () {
        let ville = $("#recherche").val();
        $.getJSON('https://api-adresse.data.gouv.fr/search?q=' + ville, function (result) { // Procédure AJAX avec décodage JSON intégré sur l'API adresse.data.gouv.fr            
            let longitude = result.features[0].geometry.coordinates[0];
            let latitude = result.features[0].geometry.coordinates[1];
            let latlngPoint = new L.LatLng(latitude, longitude);
            //on déclenche le clic sur mymap aux cordonnées de latlngPoint
            mymap.setView([latitude, longitude], 13);

            mymap.fireEvent('click', {
                latlng: latlngPoint,
                layerPoint: mymap.latLngToLayerPoint(latlngPoint),
                containerPoint: mymap.latLngToContainerPoint(latlngPoint)
            });
        });
    })


    const myAPIKey = "ac2a98485a22455f8fc4c47d38f33e12";
    var IconResto = L.icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=red&icon=hamburger&iconType=awesome&apiKey=${myAPIKey}`,
        iconSize: [30,37],
        iconAnchor: [16,32],
        popupAnchor: [0,-37]
    });
    var idami=document.getElementById("idami").value;
    $.ajax({
        url: 'index.php?controle=carte&action=listefavAmi',
        type: 'POST',
        data: {"idami" : idami},
        dataType: 'Json',
        error: function(xhr, status, error) {
            alert("ERROR "+error);
            },
            
        success: function(response){
    
            var k = response['liste'].length;
            let str ="";
            for (let j=0; j< k; j++){
                str+= "Nom : "
                str+= response['liste'][j]["nom"];
                str+= "<br>";
                str+= "Adresse : "
                str+= response['liste'][j]["adresse"];
                str+= "<br> ";
                if(!response['liste'][j]['note'])
                    str+="Note : Non noté <br> <hr>";
                else
                    str+="Note : " + response['liste'][j]["note"] + "<br> <hr>";

            }
            document.getElementById("ListeFav").innerHTML = str;
            for (var i = 0; i < response['liste'].length; i++) {
                var item = response['liste'][i];
                marker = new L.marker([item.lat,item.lng], {icon: IconResto}).bindPopup(item.nom);
                mymap.addLayer(marker);
            }
            variable = response;
            console.log(response['liste']);
        }

    });

});