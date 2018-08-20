<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/form.css">
</head>

<body>
<?php
ini_set('display_errors', 1);

//convert the stdClass Object into a php array
foreach($result as $key => $data){
    $building_array[$key] = (array)$data;
}

$building_json = json_encode($building_array);
//var_dump($building_json);
?>
<div id="form-div">
    <div id="title-div">
        <p>Edit Building</p>
    </div>
    </br>
    <script type="text/javascript">
        function submitForm(action) {
            var form = document.getElementById('form');
            form.action = action;
            form.submit();
        }
    </script>
    <form method="post" id="form">
        <table>
            <tr>
                <td>
                    Name :
                </td>
                <td>
                    <input type="text" name="name" id="name" value="<?php echo $name ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Description :
                </td>
                <td>
                    <input type="text" name="description" id="name" value="<?php echo $description ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Latitude :
                </td>
                <td>
                    <input type="text" name="latitudes" id="infoLat" value="<?php echo $latitudes ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Longitude :
                </td>
                <td>
                    <input type="text" name="longitudes" id="infoLng" value="<?php echo $longitudes ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="id" id="id" value="<?php echo $id ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="graphId" id="graphId" value="<?php echo $graph_id ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" id="update" onclick="submitForm('<?php echo base_url()?>manage_building/change_building')" name="update" value="Update building">
                </td>
                <td>
                    <input type="submit" id="delete" onclick="submitForm('<?php echo base_url()?>manage_building/delete_building')" name="delete" value="Delete building">
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="map"></div>
<script type="text/javascript">
    var line;
    var source;
    var map;
    var maparray;
    var polyArray;
    var graphArray;
    var path;
    var temp;
    var flag;
    var outJSON = {};
    var polyindex = [];
    var graph_id;
    var building;

    var geocoder = new google.maps.Geocoder();

    function geocodePosition(pos) {
        geocoder.geocode({
            latLng: pos
        });
    }

    function updateMarkerPosition(latLng) {
        document.getElementById('infoLat').setAttribute('value', parseFloat(latLng.lat()));
        document.getElementById('infoLng').setAttribute('value', parseFloat(latLng.lng()));
        // document.getElementById('graphId').setAttribute('value', this.id.value);
        // alert(this.id.value);
    }

    function initialize() {
        var latLng = new google.maps.LatLng(<?php echo $latitudes ?>, <?php echo $longitudes ?>);
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: latLng,
            // mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var buildings = <?php echo $building_json; ?>;
        buildings = JSON.parse(JSON.stringify(buildings));
        // alert(buildings);
        for(var a = 0; a < buildings.length; a++)
        {
            //console.log(buildings[a]);
            var id = buildings[a]['id'];
            var lat = buildings[a]['latitudes'];
            var lng = buildings[a]['longitudes'];
            var name = buildings[a]['name'];
            var description = buildings[a]['description'];
            var g_id = buildings[a]['graph_id'];

            var building_marker = new google.maps.Marker({
                position: {'lat': parseFloat(lat), 'lng': parseFloat(lng)},
                map: map
            });

            var content = '<b>' + name + '</b>' + '</br>' + description;

            var info_window = new google.maps.InfoWindow();

            google.maps.event.addListener(building_marker, 'mouseover', (function (building_marker, content, info_window) {
                return function () {
                    info_window.setContent(content);
                    info_window.open(map, building_marker);
                };
            })(building_marker, content, info_window));

            google.maps.event.addListener(building_marker, 'mouseout', (function (building_marker, info_window) {
                return function () {
                    info_window.close();
                };
            })(building_marker, info_window));
        }

        map.addListener('dblclick', sendData);
        // mapdata = '{"graphs":[{"vertexes":[{"lng":79.859614,"id":10,"lat":6.903579},{"lng":79.859726,"id":11,"lat":6.90225},{"lng":79.85948,"id":12,"lat":6.902409}],"edges":[{"destination":10,"id":9,"source":12},{"destination":12,"id":11,"source":11}],"id":16}],"polygons":[{"vertexes":[{"lng":79.858825,"lat":6.90357},{"lng":79.86155,"lat":6.903602},{"lng":79.860821,"lat":6.901334},{"lng":79.859147,"lat":6.902622}],"id":16}]}';
        var urlPoly = "<?=$this->config->item('server_url');?>";
        var method = "POST";
        var mapData = JSON.stringify({"type": "mapRequest"});
        var shouldBeAsync = true;
        var requestMap = new XMLHttpRequest();
        requestMap.onload = function () {
            var status = requestMap.status; // HTTP response status, e.g., 200 for "200 OK"
            var data = requestMap.response;
            // alert(data);
            maparray = JSON.parse(data);
            // //alert(dataPoly);
            polyArray = maparray.polygons;
            graphArray = maparray.graphs;
            loadmap();
            line = [];
            temp = [];
            flag = 0;
            source = [];
            // cestination = [];
            // var verticelatlng = [];
            // var verticepos = [];
            for (var i = 0; i < polyArray.length; i++) {
                path = [];
                // graph = [];
                var polyObject = polyArray[i].vertexes;
                // alert(JSON.stringify(polyObject));
                var polydraw = new google.maps.Polygon({
                    paths: polyObject,
                    strokeColor: '#aeb20c',
                    strokeOpacity: 0.8,
                    strokeWeight: 3,
                    fillColor: '#eaf01b',
                    fillOpacity: 0.35,
                    id: polyArray[i].id
                });
                polydraw.setMap(map);
                outJSON[polyArray[i].id] = [];
                polyindex.push(polyArray[i].id);
                polydraw.addListener('click', function () {
                    document.getElementById('graphId').setAttribute('value', this.id.value);
                });
                // newpoint.addListener('click', pointone);
            }
//                    alert(data);
        }
        requestMap.open(method, urlPoly, shouldBeAsync);
        requestMap.send(mapData);

        var icon = {
            url: '<?php echo base_url(); ?>/assets/drawable/marker_blue.png',
            scaledSize: new google.maps.Size(25, 40), // scaled size
        };

        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            icon: icon,
            draggable: true
        });
        // Update current position info.
        updateMarkerPosition(latLng);
        geocodePosition(latLng);
        google.maps.event.addListener(marker, 'drag', function () {
            // updateMarkerStatus('Dragging...');
            updateMarkerPosition(marker.getPosition());
        });
        google.maps.event.addListener(marker, 'dragend', function () {
            // updateMarkerStatus('Position Found!');
            geocodePosition(marker.getPosition());
            // document.getElementById('graphId').setAttribute('value', polydraw.id.value);
        });
    }

    function loadmap() {
        flag = 1;
        for (var z = 0; z < graphArray.length; z++) {
            var sourcelat, sourcelng, destlat, destlng, sourId;
            var graphVertexes = {};
            for (var verti = 0; verti < graphArray[z].vertexes.length; verti++) {
                sourcelat = graphArray[z].vertexes[verti]["lat"];
                sourcelng = graphArray[z].vertexes[verti]["lng"];
                sourId = graphArray[z].vertexes[verti]["id"];
                var sourcepoint = {'lat': sourcelat, 'lng': sourcelng};
                graphVertexes[sourId] = sourcepoint;
            }
            for (var k = 0; k < graphArray[z].edges.length; k++) {
                var sourceid = graphArray[z].edges[k]["source"];
                var destid = graphArray[z].edges[k]["destination"];
                var graphline = new google.maps.Polyline({
                    path: [graphVertexes[sourceid], graphVertexes[destid]],
                    strokeColor: '#E2E054',
                    strokeOpacity: 1.0,
                    strokeWeight: 5
                });
                graphline.setMap(map);
                graphline = [];
            }//
        }
    }

    $(input).onclick(function () {
        $("#main").load("Admin_home/buildings");
    });

    // Onload handler to fire off the app.
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$this->config->item('api_key');?>&libraries=places,geometry&callback=initialize"
        async defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>