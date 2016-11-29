<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DreamPanel | Admin</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/admin/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.6.1/css/alertify.min.css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/assets/admin/dist/css/skins/_all-skins.min.css">
    <script src="/assets/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="//cdn.jsdelivr.net/alertifyjs/1.6.1/alertify.min.js"></script>
    <script src="//dreamcraft.su/assets/js/jquery.inputhistory.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.0/Chart.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<a style="visibility: hidden;" id="csrf-token" csrf-key="<?=$csrf['name']?>" csrf-value="<?=$csrf['hash']?>"></a>
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="<?=site_url('/')?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>D</b>C</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Dream</b>Craft</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/skin/head/<?=$login?>" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?=$login?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="/skin/head/<?=$login?>" class="img-circle" alt="User Image">

                                <p>
                                    <?=$login?>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/profile" class="btn btn-default btn-flat">Профиль</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/logout" class="btn btn-default btn-flat">Выход</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/skin/head/<?=$login?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?=$login?></p>
                    <a href="/profile"><i class="fa fa-circle text-success"></i> Онлайн</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">Главная навигация</li>
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Статистика</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=site_url('stat')?>"><i class="fa fa-circle-o"></i> Статистика</a></li>
                        <li><a href="<?=site_url('stat/active')?>"><i class="fa fa-circle-o"></i> Активность</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Статические страницы</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=site_url('page')?>"><i class="fa fa-circle-o"></i> Список страниц</a></li>
                        <li><a href="<?=site_url('page/constants')?>"><i class="fa fa-circle-o"></i> Переменные</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?=site_url('shop')?>">
                        <i class="fa fa-th"></i> <span>Магазин блоков</span>
                    </a>
                </li>
                <li>
                    <a href="<?=site_url('groups')?>">
                        <i class="fa fa-group"></i> <span>Донат группы</span>
                    </a>
                </li>
                <li>
                    <a href="<?=site_url('rcon')?>">
                        <i class="fa fa-laptop"></i> <span>Консоли серверов</span>
                    </a>
                </li>
                <li>
                    <a href="<?=site_url('user')?>">
                        <i class="fa fa-user"></i> <span>Поиск игрока</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>Настройки</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=site_url('settings')?>"><i class="fa fa-circle-o"></i> Основные</a></li>
                        <li><a href="<?=site_url('settings/create')?>"><i class="fa fa-circle-o"></i> Создание переменной</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-server"></i> <span>Сервера</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=site_url('server')?>"><i class="fa fa-circle-o"></i> Список серверов</a></li>
                        <li><a href="<?=site_url('server/add')?>"><i class="fa fa-circle-o"></i> Добавить сервер</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?=site_url('support')?>">
                        <i class="fa fa-envelope"></i> <span>Поддержка</span>
                        <small class="label pull-right bg-yellow"><?/*=$support['count']*/?></small>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>Файл-менеджер</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?=site_url('file/views')?>"><i class="fa fa-circle-o"></i> Страницы</a></li>
                        <li><a href="<?=site_url('file/assets')?>"><i class="fa fa-circle-o"></i> Статический контент</a></li>
                        <li><a href="<?=site_url('file/htaccess')?>"><i class="fa fa-circle-o"></i> HtAccess</a></li>
                        <li><a href="<?=site_url('file/servers')?>"><i class="fa fa-circle-o"></i> Сервера</a></li>
                    </ul>
                </li>
                <li><a href="<?=site_url('permissions')?>"><i class="fa fa-book"></i> <span>Редактор PermissionEx</span></a></li>
                <li class="header">ОШИБКИ</li>
                <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>0</span></a></li>
                <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>0</span></a></li>
                <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>0</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Админ-панель
                <small>v2.0</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">