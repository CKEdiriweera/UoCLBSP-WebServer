<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/form.css">
        <script src="<?php echo base_url() ?>assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <style>
            input[type=text], select {
                font-family: "roboto";
                padding: 12px 12px;
                margin: 18px 0px 12px 10px;
                display: inline-block;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }
            button{
                background-color: #AF7AC5;
                color: #FFFFFF;
                padding: 14px 10px;
                /*margin-left: 5px;*/
                /*float: right;*/
                border: none;
                cursor: pointer;
            }
            .ui-autocomplete{
                background-color: white;
                list-style-type: none;
                padding-left: 10px;
                width: 239px;
                border: 0.1px solid gray;
            }
            @import url('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

            .isa_error {
                margin: 10px 0px;
                padding:12px;

            }
            .isa_error {
                color: #D8000C;
                background-color: #FFD2D2;
            }
            .isa_error i {
                margin:10px 22px;
                font-size:2em;
                vertical-align:middle;
            }
        </style>
    </head>

    <body>
    <?php
    ini_set('display_errors', 1);

    //convert the stdClass Object into a php array
    foreach($result as $key => $data){
        $building_array[$key] = (array)$data;
    }
    //if(isset($building_array)){
    //    $building_json = json_encode($building_array);
    //}

    $building_json = json_encode($building_array);
    //echo $building_json;

    //        var_dump($building_json);
    ?>

    <script src=<?php echo base_url().'assets/js/jquery-3.3.1.js'?>"type=text/javascript"></script>
    <script src=<?php echo base_url().'assets/js/bootstrap.js'?>"type=text/javascript"></script>
    <script src=<?php echo base_url().'assets/js/jquery-ui.js'?>"type=text/javascript"></script>

    <script>
        //$(document).ready(function(){
        //    $( "#room_type" ).autocomplete({
        //        source: "<?php //echo site_url('Manage_rooms/get_autocomplete_room_type/?');?>//",
        //    });
        //
        $( "#building_name" ).autocomplete({
            source: "<?php echo site_url('Manage_rooms/get_autocomplete_building/?');?>",
        });

        $(document).ready(function(){
            $.ajax({
                url: '<?php echo base_url('Manage_rooms/get_room_types'); ?>',
                method: 'GET',
                //data: id,
                // dataType: 'json',
                success: function (response) {

                    var res = JSON.parse(response);

                    for (var i = 0; i < res.length; i++)
                    {
                        $('#room_type').append( `<option value= '${res[i].type}'> ${res[i].type}</option>`);
                    }
                },
                error: function (response) {
                    console.log(response);
                    swal({
                        type: 'error',
                        text: 'something went wrong!'
                    });
                }
            });
        });

    </script>


    <script>
        function addRoom() {

            var room_name = document.getElementById('room_name').value;
            var description = document.getElementById('desc').value;
            var floor = document.getElementById('floor').value;
            var type = document.getElementById('room_type').value;
            var building = document.getElementById('building_name').value;

            if(room_name == "" || description == "" || floor == "" || type == "" || building == "")
            {
                document.getElementById("validation").style.display = "block";
                $(".alert").alert();
            }else
            {
                $.ajax({
                    url: '<?php echo base_url('Manage_rooms/add_room'); ?>',
                    method: 'POST',
                    data: {'name':room_name, 'description':description, 'floor':floor, 'room_type':type, 'building_name':building},
                    // dataType: 'json',
                    success: function () {
                        swal(
                            'Good job!',
                            'Room has been added',
                            'success'
                        );
                        document.getElementById("validation").style.display = "none";
                    },
                    error: function (response) {
                        swal({
                            type: 'error',
                            text: 'something went wrong!'
                        });
                    }
                });
            }

            // alert(type);

            document.getElementById('room_name').value = '';
            document.getElementById('desc').value = '';
            document.getElementById('floor').value = '';
            document.getElementById('room_type').value = '';
            document.getElementById('building_name').value = '';

            event.preventDefault();
        }
    </script>

    <div id="main">
        <div id="form-div">
            <div id="title-div">
                <p>Add Room</p></div>
            </br>
            <form>
                <div id="validation" class="isa_error" style="display: none; width: 375px">
                    <i class="fa fa-times-circle"></i>
                    All fields required!
                </div>
                <table>
                    <tr>
                        <td>
                            Name :
                        </td>
                        <td>
                            <input type="text" name="room_name" id="room_name">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Description :
                        </td>
                        <td>
                            <textarea rows="1.5" cols="30" name="description" id="desc"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Floor Number:
                        </td>
                        <td>
                            <input type="text" name="floor" id="floor" value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Room Type :
                        </td>
                        <td>
<!--                            <input type="text" class="ui-widget" name="room_type" id="room_type" value="">-->
                            <select name="room_type" id="room_type">
                                <option disabled selected>Select a Room Type</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Building :
                        </td>
                        <td>
                            <input type="text"  name="building_name" id="building_name" value="">
                        </td>
                    </tr>
                </table>

<!--                <input class="button" name="add_building" onclick="addBuilding()" value="Add" style="margin-top: 20px">-->
                <button class="sbutton" onclick="addRoom()">Submit</button>
                <input class="button" type="reset" name="reset" value="Reset" style="margin-top: 40px">
            </form>
        </div>
        <div id="map"></div></div>
    <script>
        var flag = 0;
        var line;
        var source;
        var map;
        var mapdata;
        var maparray;
        var polyArray;
        var graphArray;
        var path, graph, point, newpoint;
        var temp;
        var flag;
        var destination;
        var polygons = {};
        var polyid = 0;
        var startingPoint;
        var outJSON = {};
        var polyindex = [];
        var buildingLat;
        var buildingLng;
        var graph_id;
        var building;
        var building_marker;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 6.901120, lng: 79.860532},
                gestureHandling: 'greedy',
                zoom: 16
            });

            var buildings = <?php echo $building_json; ?>;
            // alert(buildings);
            buildings = JSON.parse(JSON.stringify(buildings));


            for(var a = 0; a < buildings.length; a++)
            {
                var lat = buildings[a]['latitudes'];
                var lng = buildings[a]['longitudes'];
                var name = buildings[a]['name'];
                var description = buildings[a]['description'];

                var building_marker = new google.maps.Marker({
                    position: {'lat': parseFloat(lat), 'lng': parseFloat(lng)},
                    map: map,
                    name: name
                });

                building_marker.addListener('click', select_building);

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

            function select_building(event) {
                document.getElementById('building_name').value = this.name;
            }

            // map.addListener('dblclick', sendData);
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
                    // polydraw.addListener('click', setAsBuilding);
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
                }
            }
        }

        function search_building() {
            var name = document.getElementById('name').value;
            var id = document.getElementById('id').value;
            // alert(search_building);

            $.post("<?php echo base_url(); ?>Manage_building/search_building",
                {
                    name: name,
                    id: id
                },
                function(data, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    $("#main").html(data);
                }
            );
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=$this->config->item('api_key');?>&libraries=geometry&callback=initMap"
            async defer></script>
    </body>
</html>