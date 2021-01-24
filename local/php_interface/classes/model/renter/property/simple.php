<?php
namespace Main\Base\Renter\Property;

use Main\Base\Renter\ElementTable;

class SimpleTable extends  Main\Entity\Property\SimpleTable
{
    public static function getIblockCode()
    {
        return ElementTable::getIblockCode();
    }
}