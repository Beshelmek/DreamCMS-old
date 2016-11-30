<!DOCTYPE HTML>
<html lang="ru">
<head>
    <title><?=$stitle?></title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$meta['description']?>">
    <meta name="keywords" content="<?=$meta['keywords']?>">
    <meta name="generator" content="<?=$meta['generator']?>">
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/css/style.css?v=2"/>
    <link rel="stylesheet" href="/assets/css/blue.css"/>
    <link rel="stylesheet" href="/assets/css/profile.css"/>
    <link rel="stylesheet" href="/assets/css/custom.css"/>
    <link rel="stylesheet" href="/assets/css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/assets/css/alertify.min.css"/>
    <link rel="stylesheet" href="/assets/css/bootstrap-theme.min.css"/>
    <link rel="stylesheet" href="/assets/css/star.css"/>

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">

    <!-- JS -->
    <script src="/assets/js/jquery-2.2.1.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/js/alertify.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper" class="wrapper">
    <div id='stars'></div>
    <div id='stars2'></div>
    <div id='stars3'></div>
    <a style="visibility: hidden;" id="csrf-token" csrf-key="<?=$csrf['name']?>" csrf-value="<?=$csrf['hash']?>"></a>
    <div class="navbar-wrapper">

        <div class="container content">
            <!--=== Header ===-->
            <div class="header">
                <!-- Navbar -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <a ajax-url="true"  class="navbar-brand" href="/">DreamCraft</a>
                        </div>

                        <a href="#" class="navbar-toggle-btn" data-toggle="collapse" data-target="#navbar-collapse" style="color: #fff; font-size: 25px;">
                            <span class="sr-only">Навигация</span>
                            <i class="fa fa-bars"></i>
                        </a>
                        <div class="collapse navbar-collapse navbar-responsive-collapse" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a ajax-url="true" href="/">Главная</a></li>
                                <li><a ajax-url="true" href="/forum">Форум</a></li>
                                <li><a ajax-url="true" href="/page/start">Начать игру</a></li>
                                <li><a ajax-url="true" href="/page/rules">Правила</a></li>
                                <li><a ajax-url="true" href="/page/groups">Донат</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Информация</a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a ajax-url="true" href="https://dreamcraft.su/banlist">Бан-лист</a></li>
                                        <li><a ajax-url="true" href="/page/cmd">Доступные команды</a></li>
                                        <li><a ajax-url="true" href="/page/top">Голосовать и получить монеты</a></li>
                                        <li><a ajax-url="true" href="/cases">Все о кейсах</a></li>
                                        <li><a ajax-url="true" href="/top/golos">Топ голосующих</a></li>
                                        <li><a ajax-url="true" href="/top/money">Топ богачей</a></li>
                                        <li><a ajax-url="true" href="/top/online">Топ активных</a></li>
                                        <li><a ajax-url="true" href="/page/contact">Наши контакты</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Navbar -->
            </div>
            <!--=== End Header ===-->
        </div>
    </div>


    <!--=== Carousel ===-->
    <div id="header" class="carousel slide" data-ride="carousel" data-interval="6000">
        <div class="carousel-inner">
            <div class="item active">
                <div class="carousel-img"></div>
                <?if (!$logged):?>
                    <div class="carousel-caption" style="color: white;">
                        <h1 style="color: white">Один из лучших комплексов Minecraft серверов</h1>
                        <h4 style="color: white">Мы предоставляем доступ к серверам, на которых отсутствуют лаги, редкие вайпы и почти нет запрещенных предметов. Начало игры займет всего три минуты, вперед! На встречу комфортной игре!</h4>
                        <a  ajax-url="true" class="btn-u btn-u-lg" href="/page/start">Начать играть</a>
                    </div>
                <?endif;?>
            </div>
        </div>
    </div>
    <!--=== End Carousel ===-->

    <?if ($logged):?>
        <script>
            $('.carousel-img').height(115);
            $('.carousel').css('max-height', '115px');
        </script>
    <?endif;?>

    <!--=== Container ===-->
    <div id="ajax-container" class="container margin-top-20">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8">