<?php

namespace Main\Base\Renter;

use Bitrix\Main\DB\SqlExpression;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\FileTable;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Main\Base\Renter\Property\MultipleTable;
use Main\Base\Renter\Property\SimpleTable;
use Main\Base\PointType\ElementTable as PointTypeElementTable;
use Main\Base\Mall\ElementTable as MallElementTable;
use Main\Base\Category\ElementTable as CategoryElementTable;
use Main\Base\Category\SectionTable as CategorySectionTable;

use Bitrix\Main\Entity\DataManager;

class ElementTable extends DataManager
{
    public static function getIblockId()
    {
        return parent::getIblockId(static::getIblockCode());
    }

    public static function getIblockCode()
    {
        return 'renters';
    }

    public static function getMap()
    {
        return array_merge(parent::getMap(), [
            new Reference('SECTION_PROPERTIES', SectionTable::class, ['=ref.ID' => 'this.IBLOCK_SECTION_ID']),

            new Reference('SIMPLE_PROPERTIES', SimpleTable::class, ['=ref.IBLOCK_ELEMENT_ID' => 'this.ID']),

            new Reference('MALL', MallElementTable::class, ['=ref.ID' => 'this.SIMPLE_PROPERTIES.MALL_ID']),

            new Reference('TYPE', PointTypeElementTable::class, ['=ref.ID' => 'this.SIMPLE_PROPERTIES.TYPE_ID']),

            new Reference(
                'PROPERTY_CATEGORY_ID',
                MultipleTable::class,
                array(
                    '=ref.IBLOCK_ELEMENT_ID' => 'this.ID',
                    '=ref.IBLOCK_PROPERTY_ID' => new SqlExpression(
                        '?i',
                        MultipleTable::getPropertyId('CATEGORYS_ID')
                    )
                )
            ),

            new Reference(
                'CATEGORY',
                CategorySectionTable::getEntity(),
                array(
                    '=ref.ID' => 'this.PROPERTY_CATEGORY_ID.VALUE',
                    '=ref.IBLOCK_ID' => new SqlExpression(
                        '?i',
                        CategoryElementTable::getIblockId()
                    ),
                    '=ref.ACTIVE' => new SqlExpression(
                        '?s',
                        'Y'
                    )
                )
            ),
            new ExpressionField(
                'CATEGORIES',
                'GROUP_CONCAT(DISTINCT CONCAT_WS(":", %s, %s, %s))',
                [
                    'CATEGORY.ID',
                    'CATEGORY.NAME',
                    'CATEGORY.CODE',
                ]
            ),
            new ReferenceField(
                'SECTION_PREVIEW_PICTURE_OBJ',
                FileTable::getEntity(),
                array(
                    '=ref.ID' => 'this.SECTION_PROPERTIES.UF_LOGO_SVG'
                )
            ),
            new ReferenceField(
                'SECTION_DETAIL_PICTURE_OBJ',
                FileTable::getEntity(),
                array(
                    '=ref.ID' => 'this.SECTION_PROPERTIES.DETAIL_PICTURE'
                )
            ),

        ]);

    }


}