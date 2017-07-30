<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>Книга скарг і пропозицій</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <link rel="apple-touch-icon" sizes="57x57" href="/assets/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/assets/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/assets/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/assets/css/animate.min.css" rel="stylesheet"/>
    <link href="/assets/css/style.min.css" rel="stylesheet"/>
    <link href="/botdetect/public/bdc-layout-stylesheet.css" rel="stylesheet"/>
    <link href="/assets/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="/assets/css/theme/default.css" id="theme" rel="stylesheet"/>
    <link href="/assets/plugins/DataTables/css/data-table.css" id="theme" rel="stylesheet"/>
    <!-- ================== END BASE CSS STYLE ================== -->
    <?php if (!empty($admin)) { ?>
        <link href="/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet">
    <?php } ?>
    <style>
        .updatingTable {
            background-image: url(/assets/img/spinner.gif);
            background-position: center;
            opacity: 0.3;
        }
    </style>

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body>
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">
                <img src="/assets/img/icom.jpg" width="30px" height="30px" alt="">
            </a>
        </div>
        <?php if (!empty($admin)) { ?>
            <div class="collapse navbar-collapse" id="header-navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/admin/logout">Вийти</a></li>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>

<?= $content ?>

<div id="footer-copyright" class="footer-copyright">
    <div class="container">
        &copy; 2014 - 2017
    </div>
</div>


<!-- ================== BEGIN BASE JS ================== -->
<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="/assets/js/apps.min.js"></script>

<!-- ================== END BASE JS ================== -->
<script src="/assets/js/jquery.validate.js"></script>
<script src="/js/table.js"></script>
<script>
    $(document).ready(function () {
        App.init();
        jQuery.validator.addMethod("fullEmail", function (value, element) {
            return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
        }, 'Please enter a valid email address.');
        table.init();
    });
</script>

<?php if (!empty($admin)) { ?>
    <script src="/bower_components/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/admin.js"></script>
<?php } ?>
</body>
</html>