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
            <p>Edit Person</p>
        </div>
        </br>
        <form method="post" action="<?php echo base_url() ?>index.php/Manage_people/change_people">
            <table>
                <tr>
                    <td>
                        Name :
                    </td>
                    <td>
                        <input type="text" name="name" id="name1" value="<?php echo $name ?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Designation :
                    </td>
                    <td>
                        <input type="text" name="designation" id="designation" value="<?php echo $designation ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Description :
                    </td>
                    <td>
<!--                        <input type="text" name="description" id="description" value="--><?php //echo $description ?><!--">-->
                        <textarea name="description" id="description"><?php echo htmlentities($description);  ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Room:
                    </td>
                    <td>
                        <input type="text" name="room_name" id="room_name" value="<?php echo $room_name ?>">
                    </td>
                </tr>

            </table>
<!--                <input type="submit" name="update" id="update_button" onclick="update_people()" value="Update">-->
<!--                <input type="submit" name="delete" id="delete_button" onclick="delete_people()" value="Delete">-->
            <button class="sbutton" onclick="update_people()">Update</button>
            <button class="rbutton" onclick="delete_people()">Delete</button>
        </form>
    </div>
    <div id="map"></div>
    <script>

        function update_people() {

            var name = document.getElementById('name1').value;
            var id = document.getElementById('id').value;
            var description = document.getElementById('description').value;
            var designation = document.getElementById('designation').value;
            var room_name = document.getElementById('room_name').value;
            // var building_name = document.getElementById('building_name').value;

            $.ajax({
                url:'<?php echo base_url('Manage_people/change_people'); ?>',
                method:'POST',
                data: {'name':name, 'id':id, 'description':description, 'designation':designation, "room_name":room_name},
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
            document.getElementById('name1').value='';
            document.getElementById('id').value='';
            document.getElementById('description').value='';
            document.getElementById('designation').value='';
            document.getElementById('room_name').value='';
            // document.getElementById('building_name').value='';
        }

        function delete_people() {

            var id = document.getElementById('id').value;

            swal({
                title: `Are you sure you want to delete?`,
                text: `You wont be able to undo this change!`,
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
                        url:'<?php echo base_url('Manage_people/delete_people'); ?>',
                        method:'POST',
                        data: {'id':id},
                        success: function () {
                            swal(
                                'Good job!',
                                'Person has been edited',
                                'success'
                            );

                            document.getElementById('name1').value='';
                            document.getElementById('id').value='';
                            document.getElementById('description').value='';
                            document.getElementById('designation').value='';
                            document.getElementById('room_name').value='';

                        },
                        error: function (response) {
                            swal({
                                type: 'error',
                                text: 'something went wrong!'
                            });
                        }
                    });
                }
            });
            event.preventDefault();
        }
    </script>
</div>
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>