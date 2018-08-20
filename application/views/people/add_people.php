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
        $( "#room_name" ).autocomplete({
            source: "<?php echo site_url('Manage_people/get_autocomplete_room_name/?');?>",
        });
    });
</script>

    <div id="form-div">
        <div id="title-div">
                <p>Add People</p></div>
            </br>
            <form method="post" action="<?php echo base_url()?>index.php/manage_people/add_people">

                <table>
                    <tr>
                        <td>
                            Name :
                        </td>
                        <td>
                            <input type="text" name="people_name">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Designation :
                        </td>
                        <td>
                            <textarea rows="1.5" cols="30" name="designation"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Description :
                        </td>
                        <td>
                            <input type="text" name="description" id="description" value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Room Name :
                        </td>
                        <td>
                            <input type="text" name="room_name" id="room_name" value="">
                        </td>
                    </tr>

                </table>

                <input class="button" type="submit" name="add_people" value="Add"style="margin-top: 20px">
                <input class="button" type="reset" name="reset" value="Reset"style="margin-top: 20px">

            </form>
        </div>
<div id="map"></div>
</body>
</html>