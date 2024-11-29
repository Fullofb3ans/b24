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
echo "<div style='display:flex; flex-direction:row; align-items:flex-start; justify-content: center; gap:20px;'>";
foreach ($docs as $doc) {
    echo "<div class='accordion' style='padding: 2%; border: 1px solid #ACB5BD; border-radius: 10px; width: fit-content;'>
    <details open class='accordion__details'>
                <summary class='accordion__summary' style='cursor:pointer;'>
                    {$doc['NAME']}
                </summary>";
                
                foreach($doc['PROCEDURA_ID'] as $procedura){
                    echo "<p class='accordion__title'>". $proceduraList[$procedura] . "</p>";
                }
                echo "</details>
                </div>";

}
echo "</div>";

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>
