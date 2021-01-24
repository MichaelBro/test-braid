<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Entity\ExpressionField;
use Main\Base\Landing\Restrictions\ElementTable as RestrictionTable;
use Main\Base\Renter\ElementTable as RenterElementTable;

class Restrictions extends CBitrixComponent
{
    public function executeComponent()
    {
        if ($this->startResultCache()) {
            $this->getData();

            global $CACHE_MANAGER;
            $CACHE_MANAGER->RegisterTag("iblock_id_" . RestrictionTable::getIblockId());
            $CACHE_MANAGER->RegisterTag("iblock_id_" . RenterElementTable::getIblockId());

            if (empty($this->arResult)) {
                $this->abortResultCache();
                @define("ERROR_404", "Y");
                return;
            }
            $this->includeComponentTemplate();
        }
    }

    private function getData()
    {
        $obResult = RenterElementTable::query()
            ->setFilter([
                'IBLOCK_ID' => RenterElementTable::getIblockId(),
                '=ACTIVE' => 'Y',
                '=ID' => $this->arParams['IDS'],
                'SIMPLE_PROPERTIES.DO_NOT_SHOW' => false,
            ])
            ->setSelect([
                "ID",
                "NAME",
                "CATEGORIES",
                "PREVIEW_PICTURE",
                "DETAIL_PICTURE",
                "SECTION_PREVIEW_PICTURE_ID" => 'SECTION_PREVIEW_PICTURE_OBJ.ID',
                "SECTION_DETAIL_PICTURE_ID" => 'SECTION_DETAIL_PICTURE_OBJ.ID',
            ]);

        $arItems = $obResult->fetchAll();// dont use "fetch()" with "::query()" !!! if use fetch, server return 504 error

        foreach ($arItems as $arItem) {
            $arItem['CATEGORIES_NAMES'] = $this->prepareCategory($arItem["CATEGORIES"]);
            $arItem['PREVIEW_PICTURE_SRC'] = CFile::GetPath($arItem['PREVIEW_PICTURE'] ?: $arItem['SECTION_PREVIEW_PICTURE_ID']);
            $arItem['DETAIL_PICTURE_SRC'] = CFile::GetPath($arItem['DETAIL_PICTURE'] ?: $arItem['SECTION_DETAIL_PICTURE_ID']);

            $this->arResult[] = $arItem;
        }

    }

    private function prepareCategory($strCategories): string
    {
        $arCategoriesName = [];
        foreach (explode(',', $strCategories) as $strCategory) {
            [$categoryId, $categoryName, $categoryCode] = explode(':', $strCategory);

            if (strpos($categoryCode, '~') === false || strpos($categoryName, '##') === false) {
                $arCategoriesName[] = $categoryName;
            }
        }
        return implode(', ', $arCategoriesName);
    }
}
