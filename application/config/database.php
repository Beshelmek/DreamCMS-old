<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| НАСТРОЙКА ПОДКЛЮЧЕНИЯ К БД
| -------------------------------------------------------------------
| Следуйте комментариям к каждому значению.
|
| Будте аккуратны, не показывайте никому этот файл!
|
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',     // Хост вашей БД
	'username' => 'main',          // Имя пользователя
	'password' => 'dc_main1404',   // Пароль пользователя
	'database' => 'site',          // Название базы данных
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
