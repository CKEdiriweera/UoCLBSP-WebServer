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

    <script>
        function addPeople() {

            var people_name = document.getElementById('people_name').value;
            var designation = document.getElementById('designation').value;
            var description = document.getElementById('description').value;
            var room_name = document.getElementById('room_name').value;
            // var building = document.getElementById('building_name').value;

            if(people_name == "" || designation == "" || description == "" || room_name == "")
            {
                document.getElementById("validation").style.display = "block";
                $(".alert").alert();
            }else
            {
                $.ajax({
                    url: '<?php echo base_url('Manage_people/add_people'); ?>',
                    method: 'POST',
                    data: {'people_name':people_name, 'designation':designation, 'description':description, 'room_name':room_name},
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
                        alert('hehe');
                        console.log(response);
                        swal({
                            type: 'error',
                            text: 'something went wrong!'
                        });
                    }
                });
            }


            document.getElementById('people_name').value = '';
            document.getElementById('designation').value = '';
            document.getElementById('description').value = '';
            document.getElementById('room_name').value = '';
            event.preventDefault();
        }
    </script>

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

<script>

</script>

    <div id="form-div">
        <div id="title-div">
                <p>Add People</p></div>
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
                            <input type="text" name="people_name" id="people_name">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Designation :
                        </td>
                        <td>
                            <textarea rows="1.5" cols="30" name="designation" id="designation"></textarea>
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

<!--                <input class="button" type="submit" name="add_people" value="Add"style="margin-top: 20px">-->
<!--                <input class="button" type="reset" name="reset" value="Reset"style="margin-top: 20px">-->
                <button onclick="addPeople()" class="sbutton" >Submit</button>
                <button type="reset" class="rbutton">Reset</button>

            </form>
        </div>
<div id="map"></div>
</body>
</html>