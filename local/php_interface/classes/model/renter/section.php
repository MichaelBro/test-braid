<?php
namespace Main\Base\Renter;

class SectionTable extends Main\Entity\SectionTable
{
    public static function getUfId()
    {
        return sprintf('IBLOCK_%d_SECTION', ElementTable::getIblockId());
    }
}