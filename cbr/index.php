<?php

use Bitrix\Main\Application;

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

$APPLICATION->SetTitle('Курс валют');

$request = Application::getInstance()->getContext()->getRequest();

$APPLICATION->IncludeComponent('cbr', '.default', [
    'CACHE_TIME' => 86400,
    'CACHE_TYPE' => 'A',
    'SELECT_CURRENCY' => $request->getPost('currency'),
]);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
