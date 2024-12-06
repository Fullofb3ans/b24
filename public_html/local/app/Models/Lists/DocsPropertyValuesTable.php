<?php

namespace Models\Lists;

use Bitrix\Main\Entity\ReferenceField;
use Models\AbstractIblockPropertyValuesTable;

class DocsPropertyValuesTable extends AbstractIblockPropertyValuesTable
{
    public const IBLOCK_ID = 16;

    public static function getMap(): array
    {
        $map = [
            'PROCEDURA' => new ReferenceField(
                'PROCEDURA', 
                DocsProcedurePropertyValuesTable::class, 
                ['=this.PROCEDURA_ID' => 'ref.IBLOCK_ELEMENT_ID']
            )
        ];

        return parent::getMap() + $map; 

    }
}