window.addEventListener("load", function () {

    var latitudeCliquee;
    var longitudeCliquee;
    var chemins = new Array();
    var global = null;
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

    // ========================================================= Itinéraire ===========================================================================

    //Coordonnées de chatelet (centre de l'agglomération)
    // var latitudeCentre = 48.8616202897821;
    // var longitudeCentre = 2.34803910830431;

    // $("#rechercher").on("click", function () {

    //     $.ajax({ // procédure AJAX sur l'API du STIF Navitia
    //         type: "GET",
    //         url: "https://04f316f2-d3b4-4203-b395-2550565c7e49@api.navitia.io/v1/coverage/fr-idf/journeys?from=" + longitudeCliquee + "%3B" + latitudeCliquee + "&to=" + longitudeCentre + "%3B" + latitudeCentre,
    //         dataType: 'json',
    //         headers: {
    //             Authorization: 'CityPop ' + btoa('04f316f2-d3b4-4203-b395-2550565c7e49')
    //         },
    //         success: function (itineraire) {
    //             console.table(itineraire);
    //             sections = itineraire.journeys[0].sections; // On récupère les sestions de l'itinéraire
    //             sections.forEach(element => {
    //                 let couleur;
    //                 try { // On essaye de recup la couleur
    //                     couleur = "#" + element.display_informations.color;
    //                 } catch (erreur) { // Si ya pas de couleur (trajet à pied) on met un joli bleu
    //                     couleur = "#0066CC";
    //                 }

    //                 let styleLigne = { "color": couleur, "weight": 10 }; // Création du style de la layer avec la couleur du trajet

    //                 let portionChemin = element.geojson;
    //                 let geojson = L.geoJSON(portionChemin, { style: styleLigne }); // On envoie le GeoJSON à Leaflet pour créer la layer de dessins
    //                 chemins.push(geojson); // On met la layer dans le tableau pour pouvoir l'effacer ensuite
    //                 geojson.addTo(mymap); // On ajoute la layer à leaflet
    //             });

    //             let temps = Math.round(itineraire.journeys[0].duration / 60);
    //             $("#tempsItineraire").fadeIn();
    //             $(".mins").fadeIn();
    //             $("#tempsItineraire").text(temps);
    //             compteur($("#tempsItineraire"));

    //         }

    //     });
    // });

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



      // This sample uses the Autocomplete widget to help the user select a
      // place, then it retrieves the address components associated with that
      // place, and then it populates the form fields with those details.
      // This sample requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      let placeSearch;
      let autocomplete;
      const componentForm = {
        street_number: "short_name",
        route: "long_name",
        locality: "long_name",
        administrative_area_level_1: "short_name",
        country: "long_name",
        postal_code: "short_name",
      };

        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
          document.getElementById("autocomplete"),
          { componentRestrictions: { country: "fr" },
          fields: ["formatted_address", "geometry", "name"],
            types: ["establishment"]}
        );
        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        autocomplete.setFields(["address_component"]);
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", selectPlace);

      function selectPlace() {
        // Get the place details from the autocomplete object.
        global = null;
        const place = autocomplete.getPlace();
        console.log(place);
        console.log(place.name);
        console.log(place.formatted_address);
        if(!place.geometry){
            //il n'a pas selectioné un endroit
            document.getElementById("autocomplete").placeholder = "Entrez un restaurant";
            console.log("marche pas");
        } else {
            let latitude = place.geometry.location.lat();
            let longitude = place.geometry.location.lng(); 
            //document.getElementById("infoLati").innerHTML = latitude;
            let latlngPoint = new L.LatLng(latitude, longitude); 
            mymap.setView([latitude, longitude], 13);
            mymap.fireEvent('click', {
                latlng: latlngPoint,
                layerPoint: mymap.latLngToLayerPoint(latlngPoint),
                containerPoint: mymap.latLngToContainerPoint(latlngPoint)
            });
            // let info = "Nom : " + place.name + "<br> Adresse : " + place.formatted_address ;
            // document.getElementById("infos").innerHTML = info;
            document.getElementById("infoNom").innerHTML = place.name;
            document.getElementById("infoAdresse").innerHTML = place.formatted_address;

            document.getElementById("infoNom").value = place.name;
            document.getElementById("infoAdresse").value = place.formatted_address;
            document.getElementById("infoLongi").value = longitude;
            //document.getElementById("infoLati").innerHTML = latitude;
            document.getElementById("infoLati").value = latitude;
            //console.log(document.getElementById("infoLati").value);
            $("#infosEta").fadeIn();

            global = place;
            $("#ajoutEtaBtn").fadeIn();

        }
      }

      const myAPIKey = "ac2a98485a22455f8fc4c47d38f33e12";
        var IconResto = L.icon({
            iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=red&icon=hamburger&iconType=awesome&apiKey=${myAPIKey}`,
            iconSize: [30,37],
            iconAnchor: [16,32],
            popupAnchor: [0,-37]
        });

      $.ajax({
        url: 'index.php?controle=carte&action=listefav',
        type: 'GET',
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
                    str+="Note : Non noté <br>";
                else
                    str+="Note : " + response['liste'][j]["note"] + "<br>";

                str+= "<form action='./index.php?controle=carte&action=retirerfav' method='post' class='pl-2'>"
                str+= "<input class='disnone' type='text' name='idlieu' value= '" + (response['liste'][j]["lieu"]) + "' readonly>" 
                str+= "<button name='refus' type='submit' class='btn-link'>Retirer de la liste</button>"
                str+="</form><hr>"
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

    // document.getElementsByClassName("btnAmis").addEventListener("clicked", function(){
    //     document.getElementById("ListeFav").innerHTML = "";
    // })
    


});

// function compteur(object) {
//     object.prop('Counter', 0).animate(
//         {
//             "Counter": object.text()
//         }
//         ,
//         {
//             duration: 1000,
//             easing: "swing",
//             step: function (now) {
//                 object.text(Math.ceil(now));
//             }
//         }
//     );
// }