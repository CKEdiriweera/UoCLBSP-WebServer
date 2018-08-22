<!DOCTYPE html>
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
        $( "#room_type" ).autocomplete({
            source: "<?php echo site_url('Manage_rooms/get_autocomplete_room_type/?');?>",
        });

        $( "#building_name" ).autocomplete({
            source: "<?php echo site_url('Manage_rooms/get_autocomplete_building/?');?>",
        });
    });
</script>

<script>
    $(document).ready(function(){
        $.ajax({
            url: '<?php echo base_url('Manage_rooms/get_room_types'); ?>',
            method: 'GET',
            //data: id,
            // dataType: 'json',
            success: function (response) {

                var res = JSON.parse(response);

                for (var i = 0; i < res.length; i++) {
                    if (res[i].type=='<?php echo $room_type; ?>') {
                        $('#room_type').append( `<option value= '${res[i].type}' selected> ${res[i].type}</option>`);
                    }
                    else {
                        $('#room_type').append( `<option value= '${res[i].type}'> ${res[i].type}</option>`);
                    }
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

<script type="text/javascript">
    function submitForm(action) {
        // document.getElementById('room_type').value.setAttribute('room_type');
        // document.getElementById('building_name').value.setAttribute('building_name');
        var form = document.getElementById('form');
        form.action = action;
        form.submit();
    }
</script>
<div id="main">
    <div id="form-div">
        <div id="title-div">
            <p>Edit Room</p>
        </div>
        </br>
        <form method="post" id="form">
            <table>
                <tr>
                    <td>
                        Name :
                    </td>
                    <td>
                        <input type="text" name="name" id="name" value="<?php echo $name ?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Description :
                    </td>
                    <td>
                        <input type="text" name="description" id="description" value="<?php echo $description ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Floor Number :
                    </td>
                    <td>
                        <input type="text" name="floor" id="floor" value="<?php echo $floor ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Room Type :
                    </td>
                    <td>
<!--                        <input type="text" name="room_type" id="room_type" value="--><?php //echo $room_type ?><!--">-->
                        <select name="room_type" id="room_type">
                            <option disabled selected>Select a Room Type</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Building Name :
                    </td>
                    <td>
                        <input type="text" name="building_name" id="building_name" value="<?php echo $building_name ?>">
                    </td>
                </tr>
                <tr>
<!--                    <td>-->
<!--                        <input type="submit" id="update" onclick="update_room()" name="update" value="Update building">-->
<!--                    </td>-->
<!--                    <td>-->
<!--                        <input type="submit" id="delete" onclick="delete_room()" name="delete" value="Delete building">-->
<!--                    </td>-->
                </tr>
            </table>

            <div>
                <button class="sbutton" id="update" onclick="update_room()" name="update" style="width: 45%;float: left; display: inline-block">Update</button>
                <button class="rbutton" id="delete" onclick="delete_room()" name="delete" style=" width: 45%; float: right; display: inline-block">Delete</button>
            </div>

        </form>
        <script>
            function update_room() {

                var name =document.getElementById('name').value;
                var id= document.getElementById('id').value;
                var description = document.getElementById('description').value;
                var floor = document.getElementById('floor').value;
                var room_type = document.getElementById('room_type').value;
                var building_name = document.getElementById('building_name').value;

                $.ajax({
                    url:'<?php echo base_url('Manage_rooms/change_room'); ?>',
                    data: {'name':name, 'id':id, 'description':description, 'floor':floor, 'room_type':room_type, "building_name":building_name},
                    success: function () {
                        swal(
                            'Good job!',
                            'Room has been edited',
                            'success'
                        );
                    },
                    error: function (response) {
                        swal({
                            type: 'error',
                            text: 'something went wrong!'
                        });
                    }
                });

                event.preventDefault();
                document.getElementById('name').value='';
                document.getElementById('id').value='';
                document.getElementById('description').value='';
                document.getElementById('floor').value='';
                document.getElementById('room_type').value='';
                document.getElementById('building_name').value='';

            }

            function delete_room() {

                var room_id = document.getElementById('id').value;

                $.ajax({
                    url:'<?php echo base_url('Manage_rooms/get_people_for_rooms'); ?>',
                    data: {'id':room_id},
                    success: function (response) {

                        res = JSON.parse(response);
                         alert(res);
                        // console.log(response);
                        // console.log(response[0]);

                        if (res.status===false){
                            swal({
                                title: `Are you sure you want to delete?`,
                                text: `There are ${res.people_count} people inside this building!!`,
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'No, cancel!',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: true,
                            }).then((result) => {
                                if (result.value){
                                    $.ajax({
                                        url:'<?php echo base_url('Manage_rooms/delete_room'); ?>',
                                        data: {'id':room_id},
                                        success: function () {
                                            swal(
                                                'Good job!',
                                                'Room has been edited',
                                                'success'
                                            );
                                        },
                                        error: function (response) {
                                            swal({
                                                type: 'error',
                                                text: 'something went wrong!'
                                            });
                                        }
                                    });
                                    // event.preventDefault();
                                }
                            });
                            //event.preventDefault();
                        }
                        else {
                            $.ajax({
                                url:'<?php echo base_url('Manage_rooms/delete_room'); ?>',
                                data: {'id':room_id},
                                success: function () {
                                    swal(
                                        'Good job!',
                                        'Room has been edited',
                                        'success'
                                    );
                                },
                                error: function (response) {
                                    swal({
                                        type: 'error',
                                        text: 'something went wrong!'
                                    });
                                }
                            });
                        }

                    },
                    error: function (response) {
                        swal({
                            type: 'error',
                            text: 'something went wrong!'
                        });
                    }
                });
                event.preventDefault();
            }
        </script>
    </div>
    <div id="map"></div>
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
</div>
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>