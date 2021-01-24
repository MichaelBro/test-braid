<?php
namespace Main\Base\Renter\Property;

use Main\Base\Renter\ElementTable;

class MultipleTable extends  Main\Entity\Property\MultipleTable
{
    public static function getIblockCode()
    {
        return ElementTable::getIblockCode();
    }
}