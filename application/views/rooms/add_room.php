<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

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
    <div id="main">
        <div id="form-div">
            <div id="title-div">
                <p>Add Room</p></div>
            </br>
            <form method="post" action="<?php echo base_url() ?>index.php/manage_rooms/add_room">
                <table>
                    <tr>
                        <td>
                            Name :
                        </td>
                        <td>
                            <input type="text" name="room_name">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Description :
                        </td>
                        <td>
                            <textarea rows="1.5" cols="30" name="description"></textarea>
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
                            <input type="text" class="form-control" class="ui-widget" name="room_type" id="room_type" value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Building :
                        </td>
                        <td>
                            <input type="text" class="form-control" class="ui-widget" name="building_name" id="building_name" value="">
                        </td>
                    </tr>
                </table>

                <input class="button" type="submit" name="add_building" value="Add" style="margin-top: 20px">
                <input class="button" type="reset" name="reset" value="Reset"style="margin-top: 20px">
            </form>
        </div>
        <div id="map"></div></div>
    </body>
</html>