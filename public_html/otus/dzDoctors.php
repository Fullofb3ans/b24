<?php 

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetTitle('Вывод связанных полей');


echo '<h1>Врачи</h1>';

use Models\Lists\DocsPropertyValuesTable as DocsTable;

$docs = DocsTable::getList([      
		'select'=>[
          'ID'=>'IBLOCK_ELEMENT_ID',
          'NAME'=>'ELEMENT.NAME',
 		  'MANUFACTURER_ID'=>'MANUFACTURER_ID'
      ]
  ])->fetchAll();

 pr($docs);


require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>