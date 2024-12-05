<?php

namespace Models\Lists;

use Models\AbstractIblockPropertyValuesTable;

class DocsProcedurePropertyValuesTable extends AbstractIblockPropertyValuesTable
{
    const IBLOCK_ID = 17;

    public static function getMap(): array
    {
        $map = [
            'DOCTOR' => new ReferenceField(
                'DOCTOR', 
                DocsProcedurePropertyValuesTable::class, 
                ['=this.DOCTOR_ID' => 'ref.IBLOCK_ELEMENT_ID']
            )
        ];

        return parent::getMap() + $map; 

    }
}
