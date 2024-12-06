<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/HospitalClientsTable.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/Lists/DocsPropertyValuesTable.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/Lists/DocsProcedurePropertyValuesTable.php');

use Models\Lists\DocsPropertyValuesTable as DocsTable;
use Models\Lists\DocsProcedurePropertyValuesTable as ProcTable;

use Bitrix\Iblock\Iblock;

use Models\HospitalClientsTable as Clients;

$APPLICATION -> setTitle('Тест карточка пациента');


$result = HospitalClientsTable::getList([
    'select' => [
        '*',
        'PROCEDURA_NAME' => 'PROCEDURA.ELEMENT.NAME',
'DOCTORS_NAME'=> 'DOCTORS.ELEMENT.NAME'
    ],
])->fetchCollection();

echo '<div style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px;">';

foreach($result as $key => $item){
    echo '<div style="
        border: 1px solid #ccc; 
        border-radius: 8px; 
        padding: 20px; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        min-width: 300px;
        flex: 1;
        background: white;
    ">';
    
    echo '<h1 style="margin: 0 0 10px 0;">Пациент: ' . $item->getFirstName() .  '</h1>';
    echo '<h2 style="margin: 0 0 10px 0;">Возраст: ' . $item->getAge() . '</h2>';
    echo '<h3 style="margin: 0 0 10px 0;">Имя: ' . $item->getProcedura()->getElement()->getName() . '</h3>';
    echo '<h4 style="margin: 0;">Лечащий врач: ' . $item->getDoctors()->getElement()->getName(). '</h4>';
    
    echo '</div>';
}

echo '</div>';

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';

?>