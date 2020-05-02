<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/sale.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/helpers/other.php';

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
}