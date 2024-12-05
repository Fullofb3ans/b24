<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/HospitalClientsTable.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/Lists/DocsPropertyValuesTable.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/Lists/DocsProcedurePropertyValuesTable.php');

use Models\Lists\DocsPropertyValuesTable as DocsTable;
use Models\Lists\DocsProcedurePropertyValuesTable as ProcTable;

use Bitrix\Iblock\Iblock;

use Models\HospitalClientsTable as Clients;

$APPLICATION -> setTitle('Тест пейдж');


$collection = Clients::getList([
    'select' => ['*', 'CONTACT.COMPANY_ID', 'PROCEDURA.PROCEDURA_ID', 'DOCTOR.DOCTOR_ID'],
    'filter' => ['=ID' => 1],
])->fetchCollection();

foreach($collection as $key => $item){
    pr($item->getContactId());
    pr($item->getFirstName());
    pr($item->getProcedura()->getProceduraId());
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>