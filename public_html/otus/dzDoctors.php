<?php 

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

echo '<h1>Врачи</h1>';

use Bitrix\Iblock\Iblock;

function printDoctors(){
    $iblockId = 16;
    $elements = \Bitrix\Iblock\Elements\ElementdocsTable::query()
->addSelect('NAME')
->setFilter(array('=IBLOCK_ID' => $iblockId))
-> fetchCollection();

foreach($elements as $element){
pr($element->getName());
};
}

printDoctors();

function printProdcedures(){
    $iblockId = 17;
    $elements = \Bitrix\Iblock\Elements\ElementprocTable::query()
->addSelect('NAME')
->setFilter(array('=IBLOCK_ID' => $iblockId))
-> fetchCollection();

foreach($elements as $element){
pr($element->getName());
};
}

printProdcedures();



require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>