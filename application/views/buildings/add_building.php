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
    //        var_dump($building_json);
?>

<div id="form-div">
    <div id="title-div">
        <p id ="title_p">Add Building</p></div>
    </br>
    <form id="form" method="post" action="<?php echo base_url() ?>index.php/manage_building/add_building">

        <table>
            <tr>
                <td>
                    Name :
                </td>
                <td>
                    <input id="b_name" type="text" name="name">
                </td>
            </tr>

            <tr>
                <td>
                    Description :
                </td>
                <td>
                    <textarea id="b_desc" rows="1.5" cols="30" name="description"></textarea>
                </td>
            </tr>

            <tr>
                <td>
                    Latitudes :
                </td>
                <td>
                    <input type="text" name="latitudes" id="infoLat" value="" readonly="true">
                </td>
            </tr>

            <tr>
                <td>
                    Longitudes :
                </td>
                <td>
                    <input type="text" name="longitudes" id="infoLng" value="" readonly="true">
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="graphId" id="graphId" value="">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="id" id="b_id" value="">
                </td>
            </tr>

        </table>

        <input id ="s_button" class="button" type="submit" name="add_building" value="Add Building">
        <input class="button" type="reset" name="reset" value="Reset">

    </form>
</div>

<div id="map"></div>
<script>
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
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 6.901120, lng: 79.860532},
            gestureHandling: 'greedy',
            zoom: 16
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
<<<<<<< HEAD
=======

            building_marker.addListener('click', function() {
                //infowindow.open(map, marker);
                //window.location.href = "<?php //echo site_url('Manage_building/update_building');?>//?name="+name;
                // var new_name = name.replace(" ","_");
                // console.log(id);
                //window.location.href ="<?php //echo site_url('Manage_building/update_building/');?>//"+id;

                document.getElementById("form").action = "<?php echo base_url() ?>index.php/manage_building/change_building";

                document.getElementById("title_p").innerHTML = "Edit Building";
                document.getElementById("b_id").value = id;
                document.getElementById("b_name").value = name;
                document.getElementById("b_desc").innerHTML = description;
                document.getElementById("infoLat").value = lat;
                document.getElementById("infoLng").value = lng;
                document.getElementById("graphId").value = g_id;

                document.getElementById("s_button").value = "Edit Building";

                //console.log(document.getElementById("b_id").value);




                // google.maps.event.addListener(building_marker, 'drag', function () {
                //     // updateMarkerStatus('Dragging...');
                //     updateMarkerPosition(building_marker.getPosition());
                // });
                // google.maps.event.addListener(building_marker, 'dragend', function () {
                //     // updateMarkerStatus('Position Found!');
                //     geocodePosition(building_marker.getPosition());
                // });








            });
>>>>>>> 232eaf79462bab5f627fe5b93da2a1a5ec64e183
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
                polydraw.addListener('click', setAsBuilding);
                outJSON[polyArray[i].id] = [];
                polyindex.push(polyArray[i].id);
                // newpoint.addListener('click', pointone);
            }
//                    alert(data);
        }
        requestMap.open(method, urlPoly, shouldBeAsync);
        requestMap.send(mapData);
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
    function setAsBuilding(eve) {
        if(building!=null){
            building.setMap(null);
        }
        building = new google.maps.Marker({
            position: eve.latLng,
            map: map,
        });
        document.getElementById('infoLat').setAttribute('value', JSON.stringify(eve.latLng.lat()));
        document.getElementById('infoLng').setAttribute('value', JSON.stringify(eve.latLng.lng()));
        document.getElementById('graphId').setAttribute('value', this.id);
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$this->config->item('api_key');?>&libraries=geometry&callback=initMap"
        async defer></script>

</body>
</html>