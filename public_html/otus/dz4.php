<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/HospitalClientsTable.php');


$APPLICATION -> setTitle('Тест пейдж');

use Bitrix\Iblock\Iblock;

use Models\HospitalClientsTable as Clients;

$collection = Clients::getList([
    'select' => ['*', 'CONTACT.COMPANY_ID'],
    'filter' => ['=ID' => 1],
])->fetchCollection();

foreach($collection as $key => $item){
    pr($item->getContactId());
    pr($item->getFirstName());
    pr($item->getContact()->getCompanyId());
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>