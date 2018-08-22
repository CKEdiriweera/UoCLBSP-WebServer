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
        </style>
    </head>

    <body>
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
                },
                error: function (response) {
                    swal({
                        type: 'error',
                        text: 'something went wrong!'
                    });
                }
            });

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
    </body>
</html>