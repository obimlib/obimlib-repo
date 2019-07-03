<?php
/**
 * Push Message
 *
 * Страничка для интеграции PUSH-уведомлений
 *
 * @package Push_message
 * @author Oleg Pyatin o.pyatin@bimlib.pro
 */

namespace Push_Message;
/**
 * Выполняем получения абсолютного пути к корню веб-приложения и подключение
 * файлов конфигурации
 */

define('ROOT_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
require __DIR__ . '/config/bootstrap.php';
$config = require __DIR__ . '/config/main.php';

echo 'Testing';

include "classes/exceptions/RequestException.php";
include "classes/exceptions/DatabaseException.php";
include "classes/exceptions/CommonException.php";
include "classes/exceptions/ProcessException.php";
include "classes/Router.php";
include "classes/Viewer.php";
include "classes/Application.php";

Application::run($config);
