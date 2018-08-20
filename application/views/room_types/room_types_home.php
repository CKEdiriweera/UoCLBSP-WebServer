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

        #type{
            background-image: url('<?php echo base_url(); ?>assets/drawable/searchicon.png');
            background-position: 2px 8px;
            background-size: 35px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 30px 12px 40px;
            border: 2px solid #ddd;
            margin-bottom: 12px;
        }

    </style>
</head>

<body>

<script src="<?php echo base_url().'assets/js/jquery-3.3.1.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/js/bootstrap.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        $( "#type" ).autocomplete({
            minLength: 0,
            source: "<?php echo site_url('Manage_room_types/get_autocomplete/?');?>",
            focus: function( event, ui ) {
                $( "#type" ).val( ui.item.type );
                // console.log(source);
                // var_dump(source);
                return false;
            },
            select: function( event, ui ) {
                $( "#type" ).val( ui.item.type );
                $( "#id" ).val( ui.item.id );
                console.log(source);
                return false;
            }
        })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<div>" + item.type + "</div>" )
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
        <form method="post" action="<?php echo base_url() ?>index.php/manage_room_types/add_room_type">
            <input type="text" id="type" placeholder="Search room type" style="width:320px;">
<!--            <input type="text" id="id">-->
            <button type="button" onclick="search_room_types()" id="search_button" class="sbutton" style="width: 104%">Search</button>
        </form>
        <button type="button" class="sbutton" id="add_button" style="position: absolute; bottom: 50px; width: 21%">Add new room type</button>
        <script>
            $("#add_button").click(function () {
                //$("body").html("url: <?php //echo base_url()?>//index.php/manage_building/building");
                $.ajax({
                    dataType:'text',
                    type: "POST",
                    url: "<?php echo base_url() ?>index.php/manage_room_types/room_type",
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
        function search_room_types() {
            var type = document.getElementById('type').value;
            var id = document.getElementById('id').value;
            // alert(search_building);
            $.post("<?php echo base_url(); ?>Manage_room_types/search_room_type",
                {
                    type: type,
                    id: id
                },
                function(data, status){
                    // alert("Data: " + data + "\nStatus: " + status);
                    $("#main").html(data);
                }
            );
        }
    </script>
    <div id="map"></div></div>

</body>
</html>