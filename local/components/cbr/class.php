<?php

use Bitrix\Main\Web\HttpClient;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

class Cbr extends CBitrixComponent
{
    private static $url = 'http://www.cbr.ru/scripts/XML_daily.asp';

    public function executeComponent()
    {
        if ($this->startResultCache()) {

            $this->getCurrenciesData();
            $this->getCurrentCurrency();

            $this->includeComponentTemplate();

            if ($this->arResult['ERROR']) {
                $this->abortResultCache();
            }

            $this->endResultCache();
        }
    }

    private function getCurrenciesData(): void
    {
        $httpClient = new HttpClient();
        $document = $httpClient->get(self::$url);

        if ($httpClient->getStatus() === 200) {
            $documentUtf = mb_convert_encoding($document, 'utf-8', 'windows-1251');

            $xml = new \CDataXML();
            $xml->LoadString($documentUtf);

            if ($node = $xml->GetArray()) {
                $currencies = $node['ValCurs']['#']['Valute'];
                foreach ($currencies as $currency) {
                    $id = $currency['@']['ID'];
                    $this->arResult['CURRENCIES'][$id] = [
                        'ID' => $id,
                        'NAME' => $currency['#']['Name'][0]['#'],
                        'VALUE' => $currency['#']['Value'][0]['#'],
                    ];
                }
            } else {
                $this->arResult['ERROR'] = true;
            }
        } else {
            $this->arResult['ERROR'] = true;
        }
    }

    private function getCurrentCurrency(): void
    {
        if (!empty($this->arParams['SELECT_CURRENCY'])) {
            $currentId = $this->arParams['SELECT_CURRENCY'];
            $this->arResult['CURRENT'] = $this->arResult['CURRENCIES'][$currentId];
        }
    }
}