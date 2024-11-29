<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/Lists/DocsPropertyValuesTable.php');

$APPLICATION->SetTitle('Вывод врачей и их процедур');

echo '<h1>Врачи</h1>';

use Models\Lists\DocsPropertyValuesTable as DocsTable;

$docs = DocsTable::getList([      
    'select' => [
        'ID' => 'IBLOCK_ELEMENT_ID',
        'NAME' => 'ELEMENT.NAME',
		'PROCEDURA_ID',
    ]
])->fetchAll();

$proceduresAll = \Bitrix\Iblock\Elements\ElementProcTable::query()
    ->addSelect('NAME')
    ->addSelect('ID')
    ->fetchCollection();

    $proceduraList = [];
    foreach($proceduresAll as $procedura){
        $proceduraList[$procedura->getId()] = $procedura->getName();
    }

    function getProcedureName($id) {
        return $proceduraList[$id];
    }


foreach ($docs as $doc) {
    echo "<div class='accordion'>
            <details open class='accordion__details'>
                <summary class='accordion__summary'>
                    {$doc['NAME']}
                    <svg class='accordion__icon' width='18' height='10' viewBox='0 0 18 10' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path
                            fill-rule='evenodd'
                            clip-rule='evenodd'
                            d='M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L9 7.58579L16.2929 0.292893C16.6834 -0.0976311 17.3166 -0.0976311 17.7071 0.292893C18.0976 0.683417 18.0976 1.31658 17.7071 1.70711L9.70711 9.70711C9.31658 10.0976 8.68342 10.0976 8.29289 9.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z'
                            fill='#212429' />
                    </svg>
                </summary>";
                
                foreach($doc['PROCEDURA_NAME'] as $procedura){
                    echo  "<p class='accordion__title'>{$procedura}</p>";   
                }
                echo "</details>
                </div>";

}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>
