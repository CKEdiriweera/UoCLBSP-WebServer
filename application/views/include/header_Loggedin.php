
<html>

<head>
    <title>UoC Maps</title>
    <link href="<?php echo base_url(); ?>/assets/drawable/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/admin_styles.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/fontawesome-all.css" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <script>

        function signOut() {

            //var s = <?php //echo json_encode($_SESSION); ?>//;
            //console.log(s);

            window.location.href="<?php echo base_url('Login/logout'); ?>";

            //var s = <?php //echo json_encode($_SESSION); ?>//;
            //console.log(s);

            document.location.href = "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/UoCLBSP-WebServer/";

        }

    </script>


<meta name="google-signin-client_id" content="<?php echo $this->config->item('oauth_key');?>">
<!--    <script type = 'text/javascript' src = "--><?php //echo base_url(); ?><!--/assets/js/admin_panel.js"></script>-->
    <?php if($call == True) {
        echo '<script>
                $(function(){
                    $("#cont").load("Admin_home/home");
                });

    </script>';
    }
    ?>
</head>
<body style="color: black;">




<!--<a id="nav-toggle"  class="position"><span></span></a>-->


<header>
           <div class="container" style="width: 100%;">

                   <a data-target="Admin_home/home"><img src="<?php echo base_url();?>/assets/drawable/web_icon.png" height="45px"></a>
                   <img src="<?php echo $this->session->userdata('img');?>" height="45px" style="float: right; padding-right: 110px;">
                   <a id="signoutbutton" href="#" onclick="signOut();" style="float: right; padding-right: 50px; padding-top: 5px">Sign Out</a>
           </div>

</header>




<main>
    <div id="cont">
    </div>
</main>

</body>
</html>