<!DOCTYPE html>
<html lang="en"><head>
    <title><?=$stitle?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="description" content="<?=$meta['description']?>">
    <meta name="keywords" content="<?=$meta['keywords']?>">
    <meta name="generator" content="<?=$meta['generator']?>">

    <link rel="stylesheet" href="<?=$tpl?>/css/font-awesome.min.css?v=5">
    <link href="<?=$tpl?>/css/bootstrap.min.css?v=5" rel="stylesheet">
    <link href="<?=$tpl?>/css/mdb.min.css?v=5" rel="stylesheet">
    <link href="<?=$tpl?>/css/style.css?v=<?=$version?>" rel="stylesheet">

    <script type="text/javascript" src="<?=$tpl?>/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="<?=$tpl?>/js/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style rel="stylesheet">
        html,
        body {
            height: 100%;
        }

        .navbar {
            background-color: transparent;
        }

        .top-nav-collapse {
            background-color: #4285F4;
        }

        footer.page-footer {
            background-color: #4285F4;
        }

        @media only screen and (max-width: 768px) {
            .navbar {
                background-color: #4285F4;
            }
        }

        .carousel {
            height: 50%;
        }

        @media (max-width: 776px) {
            .carousel {
                height: 100%;
            }
        }

        .carousel-item{
            height: 100%;
        }

        .carousel-item.active{
            height: 100%;
        }

        .carousel-inner {
            height: 100%;
        }

        .carousel-item:nth-child(1) {
            background-image: url("http://mdbootstrap.com/images/slides/slide%20(6).jpg");
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.4;
        }

        .carousel-item:nth-child(2) {
            background-image: url("http://mdbootstrap.com/images/slides/slide%20(11).jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .carousel-item:nth-child(3) {
            background-image: url("http://mdbootstrap.com/images/slides/slide%20(7).jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .flex-center {
            color: #fff;
        }
    </style>

</head>

<body>
<a style="visibility: hidden;" id="csrf-token" csrf-key="<?=$csrf['name']?>" csrf-value="<?=$csrf['hash']?>"></a>

<!--Navbar-->
<nav class="navbar navbar-dark navbar-fixed-top scrolling-navbar" style="max-height: 60px;">

    <!-- Collapse button-->
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx">
        <i class="fa fa-bars"></i>
    </button>

    <div class="container">

        <!--Collapse content-->
        <div class="collapse navbar-toggleable-xs" id="collapseEx">
            <!--Navbar Brand-->
            <a class="navbar-brand waves-effect waves-light" href="/"><?=$stitle?></a>
            <!--Links-->
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/forum">Форум</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/page/start">Начать играть</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/page/rules">Правила</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="/page/groups">Донат</a>
                </li>
                <li class="nav-item">
                    <a type="button" class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Информация</a>
                    <div class="dropdown-menu" style="position: inherit;">
                        <a class="dropdown-item" href="/banlist">Бан-лист</a>
                        <a class="dropdown-item" href="/page/cmd">Доступные команды</a>
                        <a class="dropdown-item" href="/page/top">Получить награду</a>
                        <a class="dropdown-item" href="/page/cases">Все о кейсах</a>
                        <a class="dropdown-item" href="/top/golos">Топ голосующих</a>
                        <a class="dropdown-item" href="/top/online">Топ активных</a>
                        <a class="dropdown-item" href="/page/contacts">Наши контакты</a>
                    </div>
                </li>


            </ul>
            <!--Search form-->
            <form class="form-inline waves-effect waves-light">
                <input class="form-control" type="text" placeholder="Search">
            </form>
        </div>
        <!--/.Collapse content-->

    </div>

</nav>
<!--/.Navbar-->

<!--Carousel Wrapper-->
<div id="carousel-example-1" class="carousel slide carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-1" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-1" data-slide-to="1" class=""></li>
        <li data-target="#carousel-example-1" data-slide-to="2" class=""></li>
    </ol>

    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <div class="flex-center animated fadeInDown">
                <ul>
                    <li>
                        <h1 class="h1-responsive">Material Design for Bootstrap 4</h1></li>
                    <li>
                        <p>The most powerful and free UI KIT for the newest Bootstrap</p>
                    </li>
                    <li>
                        <a target="_blank" href="http://mdbootstrap.com/getting-started/" class="btn btn-primary btn-lg waves-effect waves-light">Sign up!</a>
                        <a target="_blank" href="http://mdbootstrap.com/material-design-for-bootstrap/" class="btn btn-default btn-lg waves-effect waves-light">Learn more</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="carousel-item">
            <div class="flex-center animated fadeInDown">
                <ul>
                    <li>
                        <h1 class="h1-responsive">Lots of tutorials at your disposal</h1>
                    </li>
                    <li>
                        <p>And all of them are FREE!</p>
                    </li>
                    <li>
                        <a target="_blank" href="http://mdbootstrap.com/bootstrap-tutorial/" class="btn btn-primary btn-lg waves-effect waves-light">Start learning</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="carousel-item">
            <div class="flex-center animated fadeInDown">
                <ul>
                    <li>
                        <h1 class="h1-responsive">Visit our support forum</h1></li>
                    <li>
                        <p>Our community can help you with any question</p>
                    </li>
                    <li>
                        <a target="_blank" href="http://mdbootstrap.com/forums/forum/support/" class="btn btn-default btn-lg waves-effect waves-light">Support forum</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <a class="left carousel-control" href="#carousel-example-1" role="button" data-slide="prev">
        <span class="icon-prev" aria-hidden="true"></span>
        <span class="sr-only"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-1" role="button" data-slide="next">
        <span class="icon-next" aria-hidden="true"></span>
        <span class="sr-only"></span>
    </a>
    <!--/.Controls-->
</div>
<!--/.Carousel Wrapper-->

<br>

<!--Content-->
<div class="container">
    <?if($logged):?>
    <div class="modal fade" id="donate-modal" tabindex="-1" role="dialog" aria-labelledby="donate-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="donate-label">Пополнение счета</h4>
                </div>
                <form class="form-horizontal" action="https://unitpay.ru/pay/39791-30737" style="margin:10px">
                    <div class="modal-body">
                        <h2 class="heading-md">Мы принимаем:</h2>
                        <p>Visa, MasterCard, ЯндексДеньги, Qiwi и множество других систем.</p>

                        <div class="md-form input-group">
                            <span class="input-group-addon">Введите сумму:</span>
                            <input name="sum" value="320" style="padding-left: 10px;width: 23rem;" required pattern="\d*" type="text" class="form-control" aria-label="Рублей">
                            <span class="input-group-addon">₽</span>
                        </div>

                        <input type="hidden" name="account" value="<?=$userinfo['uuid']?>">
                        <input type="hidden" name="desc" value="Пополнение счета игрока <?=$userinfo['login']?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Перейти к оплате</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?endif;?>
    <div class="row">
        <div class="col-md-8">