<?php
session_start();
include_once __DIR__ . '/../app/helpers/url-helper.php';
require_once __DIR__ . '/../app/config/autoload.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user   = isset($_SESSION['user']) ? $_SESSION['user'] : null;

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

require_once __DIR__ . '/../routes/routes.php';

?>