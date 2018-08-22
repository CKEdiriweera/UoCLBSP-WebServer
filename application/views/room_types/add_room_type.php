<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/form.css">
</head>
<style>
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

<body>

    
    <div id="form-div">
        <div id="title-div">
                <p>Add Room Type</p></div>
            </br>
            <form method="post" action="<?php echo base_url()?>index.php/Manage_room_types/add_room_type">

                <table>
                    <tr>
                        <td>
                            Room Type:
                        </td>
                        <td>
                            <input type="text" name="type">
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
                </table>
                <input class="button" type="submit" name="add_building" value="Add">
                <input class="button" type="reset" name="cancel" value="Cancel">

            </form>

        </div>
    </body>
</html>