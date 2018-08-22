<html>
<head>
    <title>UoC Maps</title>
    <link href="<?php echo base_url(); ?>/assets/drawable/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/admin_styles.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/fontawesome-all.css" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<!--    <script src="https://apis.google.com/js/platform.js" async defer></script>-->
    <script src="<?php echo base_url() ?>assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script>
        function signOut() {
            window.location.href="<?php echo base_url('Login/logout'); ?>";
            document.location.href = "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo $this->config->item('base_url'); ?>/";

        }
    </script>


<meta name="google-signin-client_id" content="<?php echo $this->config->item('oauth_key');?>">

    <script>
        $(function(){
            $('#cont').load('User_home/home');
        });
    </script>

</head>

<body style="color: black;">
<!--<a id="nav-toggle"  class="position"><span></span></a>-->
<header>
           <div class="container" style="width: 100%">
                   <a data-target="Admin_home/home"><img src="<?php echo base_url();?>/assets/drawable/web_icon.png" height="45px"></a>

               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="float: right; right: 50px; padding-right: 100px; overflow: hidden"><img src="<?php echo $this->session->userdata('img');?>" style="width: 50px; height: 50px; border-radius: 50%; right: 50px;"><span class="caret"></span></a>
               <ul class="dropdown-menu dropdown-menu-right" role="menu">
                   <li style="padding: 5px 5px 5px 5px;"><?php echo $this->session->userdata('email');?></li>
                   <li style=" background: #AF7AC5; border-top: 1px solid #ccc; border-color: rgba(0,0,0,.2); padding: 10px; width: 100%; display: table;text-align: center;"><a id="signOutButton" href="javascript:void(0)" onclick="signOut()">Sign Out</a></li>
               </ul>

           </div>
</header>
<main>
    <div id="cont">
    </div>
</main>

</body>
</html>