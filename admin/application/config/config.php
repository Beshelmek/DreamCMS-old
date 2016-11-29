<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Домен сайта
|--------------------------------------------------------------------------
| URL вашего домена включая протокол и / на конце
| Например: https://dreamcraft.su/
*/
$config['base_url'] = 'https://dreamcraft.su/admin/';

/*
|--------------------------------------------------------------------------
| Уровень логирования
|--------------------------------------------------------------------------
|
| Вы можете отключить логи, или же настроить
| уровень их подробности:
|
|	0 = Отключить логирование
|	1 = Только ошибки
|	2 = Ошибки и отладка
|	3 = Ошибки, отладка и инфо-сообщения
|	4 = Логирование всей информации
|
| Мы рекомендуем вам использовать: 1
|
*/
$config['log_threshold'] = 1;

/*
|--------------------------------------------------------------------------
| Ключ шифрования
|--------------------------------------------------------------------------
|
| Для большей уникальности шифрования,
| рекомендуем прописать вам совершенно случайную строку.
|
| Подробнее:
| https://codeigniter.com/user_guide/libraries/encryption.html
|
*/
$config['encryption_key'] = 'gFvbf312DaaASa';

/*
|--------------------------------------------------------------------------
| Уровень сохранения Cookie
|--------------------------------------------------------------------------
|
| Установите уровень хранения cookie
| в браузере клиента:
|
| Мы рекомендуем вам использовать: .ВАШ_ДОМЕН
| Например: .dreamcraft.su
|
*/
$config['cookie_domain']	= '.dreamcraft.su';

/*
|--------------------------------------------------------------------------
| Защита CSRF
|--------------------------------------------------------------------------
|  Тут уже все настроено)
*/

$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf';
$config['csrf_cookie_name'] = 'csrf';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = FALSE;
$config['csrf_exclude_uris'] = array('rcon/*');

/*
|--------------------------------------------------------------------------
| Использовать сжатиие
|--------------------------------------------------------------------------
|
| Клиент получает страницы быстрее, но идет
| нагрузка на ЦП сервера.
| Если вы видите пустыю страницу после включения,
| отключите сжатие.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Другие параметры
|--------------------------------------------------------------------------
|
| Не советуем Вам их менять, если
| вы что-то сломаете, виняйте на себя)
|
*/

$config['index_page'] = 'index.php?';

$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-\@';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';

$config['language']	= 'english';
$config['charset'] = 'UTF-8';

$config['enable_hooks'] = TRUE;
$config['subclass_prefix'] = 'Admin_';
$config['composer_autoload'] = FALSE;


$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0777;
$config['log_date_format'] = 'd-m-Y H:i:s';


$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;


$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'PHPSESSID';
$config['sess_expiration'] = 2592000;
$config['sess_save_path'] = 'dc_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = $config['sess_expiration'];
$config['sess_regenerate_destroy'] = FALSE;


$config['cookie_prefix']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

$config['standardize_newlines'] = FALSE;

$config['global_xss_filtering'] = TRUE;

$config['time_reference'] = 'local';

$config['rewrite_short_tags'] = FALSE;

$config['proxy_ips'] = '';

function __autoload($class)
{
    if (strpos($class, 'CI_') !== 0)
    {
        if (file_exists($file = APPPATH . 'core/' . $class . '.php'))
        {
            include $file;
        }
    }
}