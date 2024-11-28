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
		'PROCEDURA_NAME' => 'PROCEDURA.ELEMENT.NAME'
    ]
])->fetchAll();

  foreach ($docs as $doc) {
    echo "<h1>{$doc['NAME']}</h1>";
}

pr($docs[0]['PROCEDURA']);

// use Models\Lists\DocsPropertyValuesTable as DocsTable;

// $docs = DocsTable::getList(
//     [      
// 		'select'=>[
//           'ID'=>'IBLOCK_ELEMENT_ID',
//           'NAME'=>'ELEMENT.NAME',
//  		  'POST'=>'POST',
// 			'PROCEDURA_NAME'=>'PROCEDURA.ELEMENT.NAME'
//       ],

//   ]
//   )->fetchAll();


// pr($docs);



require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>