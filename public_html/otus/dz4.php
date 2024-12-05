<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION -> setTitle('Тест пейдж');

use Bitrix\Iblock\Iblock;

use Models\HospitalClientsTable as Clients;

$collection = Clients::getList([
    'select' => ['*'],
    'filter' => ['=ID' => 1],
])->fetchCollection();

foreach($collection as $item){
    pr($item->getId());
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>