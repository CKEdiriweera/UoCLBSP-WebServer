<html>
<style type="text/css">
    .heading {
        color : #000;
        font-family: sans-serif;
        text-align: center;
    }
</style>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.2.1/typeahead.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link type="text/css" href="<?php echo base_url()?>/assets/css/searchStyle.css" rel="stylesheet">
</head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">

</head>
<body>
<div id="map"></div>
<script>
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    var finalPath;
    var markerA;
    var markerB;

    function initMap() {
        window.map = new google.maps.Map(document.getElementById('map'), {
            mapTypeControl: true,
            zoom: 16,
            center: {lat: 6.9022, lng: 79.8607},
            gestureHandling: 'greedy',
        });


        var source_lat = '<?php echo $source_lat?>';
        var source_lng = '<?php echo $source_lng?>';
        var destination_lat = '<?php echo $destination_lat?>';
        var destination_lng = '<?php echo $destination_lng?>';

        var urlPoly = "<?=$this->config->item('server_url');?>";
        var method = "POST";
        var polyData = JSON.stringify({"type":"polyRequest"});
        var shouldBeAsync = true;
        var requestPoly = new XMLHttpRequest();
        requestPoly.timeout = 10000;
        requestPoly.ontimeout = function(e){
            alert('request timeout');
        }
        requestPoly.onload = function () {
            var status = requestPoly.status;
            var dataPoly = requestPoly.response;
            var status = requestPoly.status;
            var polyJson = JSON.parse(dataPoly);

            var polygons = [],tempPoly = [],lat,lng,ids = [];
            for(var i=0;i<polyJson.polygons.length ; i++){
                for(var j=0;j<polyJson.polygons[i].vertexes.length ; j++){
                    lat = polyJson.polygons[i].vertexes[j]["lat"];
                    lng = polyJson.polygons[i].vertexes[j]["lng"];
                    tempPoly.push({'lat':lat,'lng':lng});
                }
                if(polyJson.polygons[i].vertexes.length>0){
                    polygons[i] = new google.maps.Polygon({paths: tempPoly});
                    ids[i] = polyJson.polygons[i]["id"];
                    tempPoly = [];

                }



            }
            var srcdst =  { 'type':'getPath',
                'source':
                    {'latitudes':'',
                        'longitudes':'',
                        'inside':1
                    },
                'destination':
                    {'latitudes':'',
                        'longitudes':'',
                        'inside':1
                    }
            };
            srcdst.source['latitudes'] = parseFloat(source_lat);
            srcdst.source['longitudes'] = parseFloat(source_lng);
            srcdst.destination['latitudes'] = parseFloat(destination_lat);
            srcdst.destination['longitudes'] = parseFloat(destination_lng);
            alert(JSON.stringify(srcdst));
           /* for(var z=0;z<polygons.length ; z++){
                if(polygons[z]){
                    if(google.maps.geometry.poly.containsLocation(source, polygons[z])){
                        srcdst.source['inside'] = ids[z];
                        alert(ids[z]);
                    }
                    if(google.maps.geometry.poly.containsLocation(destination, polygons[z])){
                        srcdst.destination['inside'] = ids[z];
                    }
                }

            }*/
            var jsonInside = JSON.stringify(srcdst);
            var url = "<?=$this->config->item('server_url');?>";
            var method = "POST";
            var postData = jsonInside;

            var shouldBeAsync = true;
            var requestPath = new XMLHttpRequest();

            requestPath.timeout = 12000;
            requestPath.ontimeout = function(e){
                alert('request timeout');
            }
            requestPath.onload = function () {
                var status = requestPath.status; // HTTP response status, e.g., 200 for "200 OK"
                var newPathJson = requestPath.response;
                if(requestPath.readyState === XMLHttpRequest.DONE && requestPath.status === 200){
                    alert(JSON.stringify(newPathJson));
                    var newPath = JSON.parse(newPathJson);

                    if(newPath.steps.length>0){
                        if(finalPath!=null){
                            finalPath.setMap(null);
                        }
                        finalPath = new google.maps.Polyline({
                            path: newPath.steps,
                            geodesic: true,
                            strokeColor: 'blue',
                            strokeOpacity: 1.0,
                            strokeWeight: 5
                        });

                        //drawing the final received path on the map
                        finalPath.setMap(window.map);
                        //putting two markers on origin and destination
                        if(markerA!=null){
                            markerA.setMap(null);
                        }
                        if(markerB!=null){
                            markerB.setMap(null);
                        }
                        markerA = new google.maps.Marker({
                            position: {lat: newPath.steps[0]['lat'], lng: newPath.steps[0]['lng']},
                            map: window.map,
                            animation: google.maps.Animation.DROP,
                            label:"A"
                        });
                        markerB = new google.maps.Marker({
                            position: {lat: newPath.steps[newPath.steps.length-1]['lat'], lng: newPath.steps[newPath.steps.length-1]['lng']},
                            map: window.map,
                            animation: google.maps.Animation.DROP,
                            label:"B"
                        });
                        //INFO windows for start and end
                        markerA.addListener('click', function() {
                            infowindowA.open(window.map, markerA);
                        });
                        var infowindowA = new google.maps.InfoWindow({
                            content: "Origin Location"
                        });
                        markerB.addListener('click', function() {
                            infowindowB.open(window.map, markerB);
                        });
                        var infowindowB = new google.maps.InfoWindow({
                            content: "Destination Location"
                        });
                        map.addListener('click', function() {
                            infowindowA.close();
                            infowindowB.close();
                        });
                        //adjust the zoom level for the path to be clearly seen
                        var markerBounds = new google.maps.LatLngBounds();

                        markerBounds.extend(markerA.position);
                        markerBounds.extend(markerB.position);
                        // map.setCenter(markerBounds.getCenter(),
                        // map.getBoundsZoomLevel(markerBounds));
                        window.map.fitBounds(markerBounds);

                    }
                    else{
                        alert('No Valid paths Available');
                    }

                }
            }
            //}
            requestPath.open(method, url, shouldBeAsync);
            //request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            //request.setRequestHeader("Authorization");
            //request.setRequestHeader("Authorization", null);
            // Or... whatever
            // Actually sends the request to the server.
            requestPath.send(postData);
        }
        requestPoly.open(method, urlPoly, shouldBeAsync);
        requestPoly.send(polyData);


    }


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$this->config->item('api_key');?>&libraries=places,geometry&callback=initMap"
        async defer></script>


</body>
</html>