<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=$title_page?> | Factory System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">

    <!-- The styles -->
    <link href="<?= base_url() ?>assets/css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="<?= base_url() ?>assets/css/charisma-app.css" rel="stylesheet">
    <!--<link href='<?= base_url() ?>assets/bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='<?= base_url() ?>assets/bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <!--<link href='<?= base_url() ?>assets/bower_components/chosen/chosen.min.css' rel='stylesheet'>-->
    <link href='<?= base_url() ?>assets/bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <!--<link href='<?= base_url() ?>assets/bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <!--<link href='<?= base_url() ?>assets/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <!--<link href='<?= base_url() ?>assets/css/jquery.noty.css' rel='stylesheet'>
    <link href='<?= base_url() ?>assets/css/noty_theme_default.css' rel='stylesheet'>
    <link href='<?= base_url() ?>assets/css/elfinder.min.css' rel='stylesheet'>
    <link href='<?= base_url() ?>assets/css/elfinder.theme.css' rel='stylesheet'>
    <link href='<?= base_url() ?>assets/css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='<?= base_url() ?>assets/css/uploadify.css' rel='stylesheet'>
    <link href='<?= base_url() ?>assets/css/animate.min.css' rel='stylesheet'>-->
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/all.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/select2.min.css">
    <!-- jQuery 
    <script src="<?= base_url() ?>assets/bower_components/jquery/jquery.min.js"></script>-->
    <!-- function javascript -->
    <script src="<?= base_url() ?>assets/function.js"></script>


    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.png">

</head>

<body>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand" href="<?= base_url() ?>"> <img alt="Charisma Logo" src="<?= base_url() ?>assets/img/logo20.png" class="hidden-xs"/>
                <span>FSystem</span></a>-->

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> <?=$this->session->userdata('user_name')?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url() ?>user/<?=$this->session->userdata('user_id')?>">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="<?= base_url() ?>login/logout_action">Logout</a></li>
                </ul>
            </div>
            

        </div>
    </div>
    <!-- topbar ends -->


        <div class="ch-container" style="padding-top: 80px">
    <div class="row">

    <? include('left_site.php') ?>

            <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <div>
    <ul class="breadcrumb">
        <li>
            <a href="<?= base_url() ?>"><?=$aplikasi?></a>
        </li>
        <li>
            <?=$title_page?>
        </li>
    </ul>
</div>