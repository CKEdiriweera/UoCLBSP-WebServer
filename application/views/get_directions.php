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
<?php echo $source_name ?>
<?php echo $destination_name ?>
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

        //getting directions
            alert('jfjf');
            window.source;
            window.destination;
            var originName = '<?php echo $source_name?>';
            var destinationName = '<?php echo $destination_name?>';
            //alert(window.placeLatsD);
            var index = 1;
            //alert(JSON.stringify(window.resultsO.Results[index]['lat']));
            for (var i = 0; i < window.placeLats.length; i++) {
                if (window.placeLats[i][0] == originName) {
                    index = window.placeLats[i][1];
                    window.source = new google.maps.LatLng(window.resultsO.Results[index]['lat'], window.resultsO.Results[index]['lng']);
                    window.destination = new google.maps.LatLng(window.resultsD.Results[index]['lat'], window.resultsD.Results[index]['lng']);
                }
            }
            // alert(source);
            // alert(destination);
            getWholePath();

        function getWholePath() {
            // var map = new google.maps.Map(document.getElementById('map'), {
            //   center: {lat: 6.901120, lng: 79.860532},
            //   zoom: 15,
            // });
            //requesting polygons from the server
            var urlPoly = "<?=$this->config->item('server_url');?>";
            var method = "POST";
            var polyData = JSON.stringify({"type": "polyRequest"});
            var shouldBeAsync = true;
            var requestPoly = new XMLHttpRequest();
            requestPoly.timeout = 10000;
            requestPoly.ontimeout = function (e) {
                alert('request timeout');
            }
            requestPoly.onload = function () {
                var status = requestPoly.status;
                //if(requestPoly.readyState === XMLHttpRequest.DONE && requestPoly.status === 200){
                // HTTP response status, e.g., 200 for "200 OK"
                var dataPoly = requestPoly.response;
                var status = requestPoly.status;
                //alert(dataPoly);
                var polyJson = JSON.parse(dataPoly);
                //alert(dataPoly);

                var polygons = [], tempPoly = [], lat, lng, ids = [];
                for (var i = 0; i < polyJson.polygons.length; i++) {
                    for (var j = 0; j < polyJson.polygons[i].vertexes.length; j++) {
                        lat = polyJson.polygons[i].vertexes[j]["lat"];
                        lng = polyJson.polygons[i].vertexes[j]["lng"];
                        tempPoly.push({'lat': lat, 'lng': lng});
                    }
                    //alert(polyJson.polygons[i].vertexes.length>0);
                    if (polyJson.polygons[i].vertexes.length > 0) {
                        //make new polygons
                        polygons[i] = new google.maps.Polygon({paths: tempPoly});
                        ids[i] = polyJson.polygons[i]["id"];
                        //if(polygons[i]){
                        //draw polygons on the map
                        //window.map.data.add({geometry: new google.maps.Data.Polygon([tempPoly])});
                        tempPoly = [];
                        //polygons[i].setMap(window.map);
                        //}
                    }


                }
                //alert(JSON.stringify(polygons));

                var source = window.source;
                var destination = window.destination;
                var srcdst = {
                    'type': 'getPath',
                    'source':
                        {
                            'latitudes': '',
                            'longitudes': '',
                            'inside': 0
                        },
                    'destination':
                        {
                            'latitudes': '',
                            'longitudes': '',
                            'inside': 0
                        }
                };
                srcdst.source['latitudes'] = source.lat();
                srcdst.source['longitudes'] = source.lng();
                srcdst.destination['latitudes'] = destination.lat();
                srcdst.destination['longitudes'] = destination.lng();
                //alert(JSON.stringify(srcdst));
                //check if the search points are inside any of the polygons
                //otherwise zero
                for (var z = 0; z < polygons.length; z++) {
                    if (polygons[z]) {
                        if (google.maps.geometry.poly.containsLocation(source, polygons[z])) {
                            srcdst.source['inside'] = ids[z];
                            alert(ids[z]);
                        }
                        if (google.maps.geometry.poly.containsLocation(destination, polygons[z])) {
                            srcdst.destination['inside'] = ids[z];
                        }
                    }

                }
                var jsonInside = JSON.stringify(srcdst);
                //alert(json);
                //sending the two points' coordinates and inside or not details
                var url = "<?=$this->config->item('server_url');?>";
                var method = "POST";
                var postData = jsonInside;
                // want shouldBeAsync = true.
                // Otherwise, it'll block ALL execution waiting for server response.
                var shouldBeAsync = true;
                var requestPath = new XMLHttpRequest();
                // request.onreadystatechange = function(){
                //  if(request.readyState == XMLHttpRequest.DONE && request.status ==200){
                //    alert('request.responseXML');
                //  }
                // }
                requestPath.timeout = 12000;
                requestPath.ontimeout = function (e) {
                    alert('request timeout');
                }
                requestPath.onload = function () {
                    var status = requestPath.status; // HTTP response status, e.g., 200 for "200 OK"
                    var newPathJson = requestPath.response;
                    //alert(status);
                    if (requestPath.readyState === XMLHttpRequest.DONE && requestPath.status === 200) {
                        //alert(newPathJson); // Returned data, e.g., an HTML document.
                        // var sampleData = '{"steps":[{"latitude": 6.903045, "longitude": 79.860281},{"latitude": 6.902116, "longitude": 79.861996},{"latitude": 6.899326, "longitude": 79.860805},{"latitude": 6.898815, "longitude": 79.860429},{"latitude": 6.899528, "longitude": 79.859785},{"latitude": 6.903181, "longitude": 79.858584},{"latitude": 6.902351, "longitude": 79.857511},{"latitude": 6.901509, "longitude": 79.856942},{"latitude": 6.901019, "longitude": 79.855193},{"latitude": 6.900242, "longitude": 79.855440}]}';
                        //alert(newPathJson);
                        var newPath = JSON.parse(newPathJson);

                        if (newPath.steps.length > 0) {
                            if (finalPath != null) {
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
                            if (markerA != null) {
                                markerA.setMap(null);
                            }
                            if (markerB != null) {
                                markerB.setMap(null);
                            }
                            markerA = new google.maps.Marker({
                                position: {lat: newPath.steps[0]['lat'], lng: newPath.steps[0]['lng']},
                                map: window.map,
                                animation: google.maps.Animation.DROP,
                                label: "A"
                            });
                            markerB = new google.maps.Marker({
                                position: {
                                    lat: newPath.steps[newPath.steps.length - 1]['lat'],
                                    lng: newPath.steps[newPath.steps.length - 1]['lng']
                                },
                                map: window.map,
                                animation: google.maps.Animation.DROP,
                                label: "B"
                            });
                            //INFO windows for start and end
                            markerA.addListener('click', function () {
                                infowindowA.open(window.map, markerA);
                            });
                            var infowindowA = new google.maps.InfoWindow({
                                content: "Origin Location"
                            });
                            markerB.addListener('click', function () {
                                infowindowB.open(window.map, markerB);
                            });
                            var infowindowB = new google.maps.InfoWindow({
                                content: "Destination Location"
                            });
                            map.addListener('click', function () {
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
                        else {
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
    }


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$this->config->item('api_key');?>&libraries=places,geometry&callback=initMap"
        async defer></script>


</body>
</html>