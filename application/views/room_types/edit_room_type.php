<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/form.css">
</head>

<body>
<div id="form-div">
    <div id="title-div">
        <p>Edit Room Type</p>
    </div>
    </br>
    <div>
        <form method="post" action="<?php echo base_url() ?>index.php/Manage_room_types/change_room_type">
            <table>
                <tr>
                    <td>
                        Type :
                    </td>
                    <td>
                        <input type="text" name="type" id="name" value="<?php echo $type ?>">
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
                        <input type="hidden" name="id" id="room_type_id" value="<?php echo $id ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="update" value="Update">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div style="width: 75%; height:100%; float:right">
</div>


</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>