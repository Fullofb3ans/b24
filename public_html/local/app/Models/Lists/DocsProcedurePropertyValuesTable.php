<?php

namespace Models\Lists;

use Models\AbstractIblockPropertyValuesTable;

class DocsProcedurePropertyValuesTable extends AbstractIblockPropertyValuesTable
{
    const IBLOCK_ID = 17;
    public static function getMap(): array
    {
        return array_merge(parent::getMap(), [
            'ID' => [
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
            ],
            'PROCEDURA_ID' => [
                'data_type' => 'integer',
                'required' => true,
            ],
            'PROCEDURA' => [
                'data_type' => ProceduraTable::class,
                'reference' => [
                    '=this.PROCEDURA_ID' => 'ref.ID'
                ],
                'join_type' => Join::TYPE_LEFT
            ]
        ]);
    }
}
