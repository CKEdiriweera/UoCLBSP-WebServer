<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/form.css">
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

        #Search{
            background-image: url('<?php echo base_url(); ?>assets/drawable/searchicon.png');
            background-position: 2px 8px;
            background-size: 35px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 30px 12px 40px;
            border: 2px solid #ddd;
            margin-bottom: 12px;
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
<script src="<?php echo base_url().'assets/js/jquery-3.3.1.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/js/bootstrap.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        $( "#Search" ).autocomplete({
            minLength: 0,
            source: "<?php echo site_url('Manage_building/get_autocomplete/?');?>",
            focus: function( event, ui ) {
                $( "#Search" ).val( ui.item.name );
                console.log(source);
                return false;
            },
            select: function( event, ui ) {
                $( "#Search" ).val( ui.item.name );
                $( "#id" ).val( ui.item.id );
                console.log(source);
                return false;
            }
        })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<div>" + item.name + "</div>" )
                .appendTo( ul );
        };
    });
</script>
<div id="main">
<div id="form-div">
    <div id="title-div">
        <p></p>
    </div>
    </br>
    <form method="post">
        <input id="Search" placeholder="Search building">
<!--    <form method="post" action="--><?php //echo base_url() ?><!--index.php/manage_building/add_building">-->
<!--        <input id="name">-->
<!--        <input type="text" id="id">-->
<!--        <input type="text" class="form-control" class="ui-widget" id="name" placeholder="Search building" style="width:320px;">-->
<!--        <input type="hidden" name="id" id="id">-->
        <button type="button" onclick="search_building()" id="search_button" class="sbutton" style="width: 100%">Search</button>
    </form>
    <button type="button" class="sbutton"  id="add_button" style="position: absolute; bottom: 50px;width:24%">Add new building</button>
    <script>
        $("#add_button").click(function () {
            //$("body").html("url: <?php //echo base_url()?>//index.php/manage_building/building");
            $.ajax({
                dataType:'text',
                type: "POST",
                url: "<?php echo base_url() ?>index.php/manage_building/building",
                success: function (response){
                    // $("#cont").html(' ');
                    $("#cont").html(response);
                    // location.replace(response);
                }
            });
        });



    </script>
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
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 6.901120, lng: 79.860532},
            gestureHandling: 'greedy',
            zoom: 16
        });

        var buildings = <?php echo $building_json; ?>;
        // alert(buildings);
        buildings = JSON.parse(JSON.stringify(buildings));
        if(buildings.length != 0)
        {
            for(var a = 0; a < buildings.length; a++)
            {
                var lat = buildings[a]['latitudes'];
                var lng = buildings[a]['longitudes'];
                var name = buildings[a]['name'];
                var description = buildings[a]['description'];

                var building_marker = new google.maps.Marker({
                    position: {'lat': parseFloat(lat), 'lng': parseFloat(lng)},
                    map: map
                });

                building_marker.addListener('dblclick', edit_building);

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

    //function sendData(ev) {
    //    var resultJson = [];
    //    for (var i = 0; i < polyindex.length; i++) {
    //        if (outJSON[polyindex[i]].length > 0) {
    //            var getElement = {};
    //            getElement['id'] = polyindex[i];
    //            getElement['paths'] = outJSON[polyindex[i]];
    //            resultJson.push(getElement);
    //        }
    //    }
    //    var finalJson = {};
    //    finalJson['type'] = "addPaths";
    //    finalJson['Changes'] = resultJson;
    //    // alert(JSON.stringify(finalJson));
    //    var urlPoly = "<?//=$this->config->item('server_url');?>//";
    //    var method = "POST";
    //    var mapData = JSON.stringify(finalJson);
    //    var shouldBeAsync = true;
    //    var requestMap = new XMLHttpRequest();
    //    var data;
    //    requestMap.onload = function () {
    //        var status = requestMap.status; // HTTP response status, e.g., 200 for "200 OK"
    //        var data = requestMap.response;
    //        // alert(data);
    //    }
    //    requestMap.open(method, urlPoly, shouldBeAsync);
    //    requestMap.send(mapData);
    //}

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

    function edit_building(event) {
        var latitudes = event.latLng.lat();
        var longitudes = event.latLng.lng();
        // alert(latitudes);
        // console.log(latitudes);
        // console.log(longitudes);

        $.post("<?php echo base_url(); ?>Manage_building/search_buildingby_latlng",
            {
                latitudes: latitudes,
                longitudes: longitudes
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