
<html>

<head>
    <title>UoC Maps</title>
    <link href="<?php echo base_url(); ?>/assets/drawable/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/admin_styles.css" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/fontawesome-all.css" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!--    <script type = 'text/javascript' src = "--><?php //echo base_url(); ?><!--/assets/js/admin_panel.js"></script>-->
    <?php if($call == True) {
        echo '<script>
                $(function(){
                    $("#cont").load("Admin_home/search");
                });

    </script>';
    }
    ?>
</head>
<body>

<!--<a id="nav-toggle"  class="position"><span></span></a>-->


<header>
           <div class="container">
          <a data-target="Admin_home/search"><img src="<?php echo base_url();?>/assets/drawable/web_icon.png" height="45px"></a>
         </div>
</header>




<main>
    <div id="cont">
    </div>
</main>

</body>
</html>