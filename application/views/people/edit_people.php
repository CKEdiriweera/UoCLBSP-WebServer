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
        $( "#room_name" ).autocomplete({
            source: "<?php echo site_url('Manage_people/get_autocomplete_room_name/?');?>",
        });
    });
</script>
<div id="main">
    <div id="form-div">
        <div id="title-div">
            <p>Edit Room</p>
        </div>
        </br>
        <form method="post" action="<?php echo base_url() ?>index.php/Manage_people/change_people">
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
                        Designation :
                    </td>
                    <td>
                        <input type="text" class="form-control" class="ui-widget" name="designation" id="designation" value="<?php echo $designation ?>">
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
                        Room:
                    </td>
                    <td>
                        <input type="text" class="form-control" class="ui-widget" name="room_name" id="room_name" value="<?php echo $room_name ?>">
                    </td>
                </tr>

            </table>
                <input type="submit" name="update" id="update_button" onclick="update_people()" value="Update">
                <input type="submit" name="delete" id="delete_button" onclick="delete_people()" value="Delete">
        </form>
    </div>
    <div id="map"></div>
    <script>

        function update_people() {

            $.post("<?php echo base_url(); ?>Manage_people/change_people",
                {
                    name: document.getElementById('name').value,
                    id: document.getElementById('id').value,
                    designation: document.getElementById('designation').value,
                    description: document.getElementById('description').value,
                    room_name: document.getElementById('room_name').value
                },
                function(data, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    $("#main").html(data);
                }
            );
        }

        function delete_people() {

            $.post("<?php echo base_url(); ?>Manage_people/delete_people",
                {
                    id: document.getElementById('id').value,
                },
                function(data, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    $("#main").html(data);
                }
            );
        }
    </script>
</div>
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>