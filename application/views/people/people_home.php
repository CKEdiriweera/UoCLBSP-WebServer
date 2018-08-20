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
        $( "#name" ).autocomplete({
            minLength: 0,
            source: "<?php echo site_url('Manage_people/get_autocomplete/?');?>",
            focus: function( event, ui ) {
                $( "#name" ).val( ui.item.name );
                // console.log(source);
                // var_dump(source);
                return false;
            },
            select: function( event, ui ) {
                $( "#name" ).val( ui.item.name );
                $( "#id" ).val( ui.item.id );
                // console.log(source);
                return false;
            }
        })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<div>" + item.name + "</div>" )
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
        <form method="post" action="<?php echo base_url() ?>index.php/manage_people/add_people">
            <input type="text" class="form-control" class="ui-widget" id="name" placeholder="Search people" style="width:320px;">
            <input type="text" id="id">
            <button type="button" onclick="search_people()" id="search_button" class="btn btn-default">Search</button>
        </form>
        <button type="button" class="btn btn-default" id="add_button" style="position: absolute; bottom: 50px;">Add new person</button>
        <script>
            $("#add_button").click(function () {
                $.ajax({
                    dataType:'text',
                    type: "POST",
                    url: "<?php echo base_url() ?>index.php/manage_people/people",
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
        function search_people() {

            $.post("<?php echo base_url(); ?>/Manage_people/search_people",
                {
                    name: document.getElementById('name').value,
                    id: document.getElementById('id').value
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