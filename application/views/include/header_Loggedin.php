<html>
<head>
    <title>UoC Maps</title>
    <link href="<?php echo base_url(); ?>/assets/drawable/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/admin_styles.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/fontawesome-all.css" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="<?php echo base_url() ?>assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script>
        function signOut() {
            window.location.href="<?php echo base_url('Login/logout'); ?>";
            document.location.href = "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo $this->config->item('base_url'); ?>/";

        }
    </script>

    <script>
        function editProfile() {
            $('#form_admin')[0].reset(); // reset form on modals

            const email = "<?php echo $this->session->userdata('email');?>";

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo base_url('Admin/get_admin_data_by_email')?>/",
                type: "GET",
                data: {"email": email},
                dataType: "JSON",
                success: function(response)
                {
                    console.log(response);

                    $('[name="id"]').val(response[0].id);
                    $('[name="name"]').val(response[0].name);
                    $('[name="email"]').val(response[0].email);
                    $('[name="telephone"]').val(response[0].telephone);

                    $('#modal_form_admin').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Admin Info'); // Set title to Bootstrap modal title

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }

        function save() {

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const telephone = document.getElementById('telephone').value;
            

            console.log(document.getElementById('telephone').value);

            if (!name || !email || !telephone){
                swal({
                    type:'error',
                    text:'Some fields are empty in the form!',
                    title:'You cannot have empty fields!'
                });
            }
            else{
                if (email=='<?php echo $_SESSION['email'];?>') {
                    $.ajax({
                        url : "<?php echo base_url('Admin/edit_admin_data')?>/",
                        type: "POST",
                        data: $('#form_admin').serializeArray(),
                        dataType: "JSON",

                        success: function(response)
                        {
                            //if success close modal and reload ajax table
                            $('#modal_form_admin').modal('hide');
                            swal(
                                'Good job!',
                                'Data has been save!',
                                'success'
                            );
                            updateData();

                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {

                            alert('Error adding / update data');

                        }
                    });
                }

                else {
                    $.ajax({
                        url : "<?php echo base_url('Admin/get_email_list')?>/",
                        type: "GET",
                        // data: $('#form_admin').serializeArray(),
                        dataType: "JSON",
                        success: function(response) {
                            response.forEach(function (element) {
                                if (element['email']==email){
                                    swal({
                                        type:'error',
                                        text:'Email is already in the database!',
                                        title:'You cannot have duplicate Emails!'
                                    });
                                }
                            })
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                        }
                    });

                }
            }
        }

    </script>

<meta name="google-signin-client_id" content="<?php echo $this->config->item('oauth_key');?>">
<!--    <script type = 'text/javascript' src = "--><?php //echo base_url(); ?><!--/assets/js/admin_panel.js"></script>-->
    <?php if($call == True) {
        echo "<script>
                $(function(){
                    $('#cont').load('Admin_home/home');
                });
    </script>";
    }
    ?>
</head>

<body style="color: black;">
<!--<a id="nav-toggle"  class="position"><span></span></a>-->
<header>
           <div class="container" style="width: 100%">
                   <a data-target="Admin_home/home"><img src="<?php echo base_url();?>/assets/drawable/web_icon.png" height="45px"></a>

               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="float: right; right: 50px; padding-right: 100px; overflow: hidden"><img src="<?php echo $this->session->userdata('img');?>" style="width: 50px; height: 50px; border-radius: 50%; right: 50px;"><span class="caret"></span></a>
               <ul class="dropdown-menu dropdown-menu-right" role="menu">
                   <li style="padding: 5px 5px 5px 5px; font-size: 1.5em"><?php echo $this->session->userdata('name');?></li>
                   <li style="padding: 5px 5px 5px 5px;"><?php echo $this->session->userdata('email');?></li>
                   <li style=" background: #AF7AC5; border-top: 1px solid #ccc; border-color: rgba(0,0,0,.2); padding: 10px; width: 100%; display: table;text-align: center;"><a id="editProfileButton" href="javascript:void(0)" onclick="editProfile()">Edit Profile</a></li>
                   <li style=" background: #AF7AC5; border-top: 1px solid #ccc; border-color: rgba(0,0,0,.2); padding: 10px; width: 100%; display: table;text-align: center;"><a id="signOutButton" href="javascript:void(0)" onclick="signOut()">Sign Out</a></li>
               </ul>

           </div>
</header>
<main>
    <div id="cont">
    </div>
</main>

<div class="modal fade" id="modal_form_admin" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Admin Info Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_admin" class="form-horizontal">
                    <input type="hidden" value="" id="id" name="id""/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-9">
                                <input name="name" id="name" placeholder="full Name" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="email" id="email" placeholder="Email" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Contact No</label>
                            <div class="col-md-9">
                                <input name="telephone" id="telephone" placeholder="Contact No" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

</body>
</html>