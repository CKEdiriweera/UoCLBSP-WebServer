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
    </style>
</head>

<body>

<script src="<?php echo base_url().'assets/js/jquery-3.3.1.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/js/bootstrap.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        $( "#name" ).autocomplete({
            minLength: 0,
            source: "<?php echo site_url('Manage_rooms/get_autocomplete/?');?>",
            focus: function( event, ui ) {
                $( "#name" ).val( ui.item.name );
                // console.log(source);
                // var_dump(source);
                return false;
            },
            select: function( event, ui ) {
                $( "#name" ).val( ui.item.name );
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
        <form method="post" action="<?php echo base_url() ?>index.php/manage_rooms/add_room">
            <input type="text" class="form-control" class="ui-widget" id="name" placeholder="Search room" style="width:320px;">
            <input type="text" id="id">
            <button type="button" onclick="search_room()" id="search_button" class="btn btn-default">Search</button>
        </form>
        <button type="button" class="btn btn-default" id="add_button" style="position: absolute; bottom: 50px;">Add new room</button>
        <script>
            $("#add_button").click(function () {
                $.ajax({
                    dataType:'text',
                    type: "POST",
                    url: "<?php echo base_url() ?>index.php/manage_rooms/rooms",
                    success: function (response){
                        // $("#cont").html(' ');
                        $("#cont").html(response);
                        // location.replace(response);
                    }
                });
            });
        </script>
    </div>

    <script>
        function search_room() {
            var name = document.getElementById('name').value;
            // alert(search_building);
            $.post("<?php echo base_url(); ?>Manage_rooms/search_room",
                {
                    name: name
                },
                function(data, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    $("#main").html(data);
                }
            );
        }
    </script>
    <div id="map"></div></div>
<script>
    var line;
    var source;
    var map;
    var maparray;
    var polyArray;
    var graphArray;
    var temp;
    var flag;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 6.901120, lng: 79.860532},
            gestureHandling: 'greedy',
            zoom: 16

        });

        // map.addListener('dblclick', sendData);

        // mapdata = '{"graphs":[{"vertexes":[{"lng":79.859614,"id":10,"lat":6.903579},{"lng":79.859726,"id":11,"lat":6.90225},{"lng":79.85948,"id":12,"lat":6.902409}],"edges":[{"destination":10,"id":9,"source":12},{"destination":12,"id":11,"source":11}],"id":16}],"polygons":[{"vertexes":[{"lng":79.858825,"lat":6.90357},{"lng":79.86155,"lat":6.903602},{"lng":79.860821,"lat":6.901334},{"lng":79.859147,"lat":6.902622}],"id":16}]}';

        // var urlPoly = "http://ec2-52-72-156-17.compute-1.amazonaws.com:1978";
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
            // loadmap();
            line = [];
            temp = [];
            flag = 0;
            source = [];
            cestination = [];
            // var verticelatlng = [];
            // var verticepos = [];

            flag = 1;
            for (var z = 0; z < graphArray.length; z++) {
                var sourcelat, sourcelng, destlat, destlng, sourId;
                var graphVertexes = {};
                for (var verti = 0; verti < graphArray[z].vertexes.length; verti++) {
                    sourcelat = graphArray[z].vertexes[verti]["lat"];
                    sourcelng = graphArray[z].vertexes[verti]["lng"];
                    sourId = graphArray[z].vertexes[verti]["id"];
                    var sourcepoint = {'lat': sourcelat, 'lng': sourcelng};

                    sourcemark = new google.maps.Marker({
                        position: sourcepoint,
                        map: map,
                        id: graphArray[z].id,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 1,
                            strokeWeight: 2,
                            fillOpacity: 0.6,
                            fillColor: "white",
                            strokeColor: "white"
                        },
                    });
                    // sourcemark.addListener('click', pointone);
                    graphVertexes[sourId] = sourcepoint;
                }

                for (var k = 0; k < graphArray[z].edges.length; k++) {
                    var sourceid = graphArray[z].edges[k]["source"];
                    var destid = graphArray[z].edges[k]["destination"];
                    var graphline = new google.maps.Polyline({
                        path: [graphVertexes[sourceid], graphVertexes[destid]],
                        strokeColor: 'white',
                        strokeOpacity: 1.0,
                        strokeWeight: 5
                    });

                    graphline.setMap(map);
                    graphline = [];
                }//
            }

        }
        requestMap.open(method, urlPoly, shouldBeAsync);
        requestMap.send(mapData);

    } //init ends

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$this->config->item('api_key');?>&libraries=geometry&callback=initMap"
        async defer></script>
</body>
</html>