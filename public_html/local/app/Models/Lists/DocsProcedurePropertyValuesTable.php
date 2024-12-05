<?php

namespace Models\Lists;

use Models\AbstractIblockPropertyValuesTable;

class DocsProcedurePropertyValuesTable extends AbstractIblockPropertyValuesTable
{
    const IBLOCK_ID = 17;

    public static function getMap()
    {
        return array_merge(parent::getMap(), [
            'ID' => [
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
            ],
        ]);
    }
}
