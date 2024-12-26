<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/HospitalClientsTable.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/Lists/DocsPropertyValuesTable.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/local/app/Models/Lists/DocsProcedurePropertyValuesTable.php');

use Models\Lists\DocsPropertyValuesTable as DocsTable;
use Models\Lists\DocsProcedurePropertyValuesTable as ProcTable;
use Models\HospitalClientsTable as HospitalClientsTable;

use Bitrix\Main\Context,	
    Bitrix\Main\Application,
    Bitrix\Main\Type\DateTime,
    Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Engine\Contract\Controllerable,
    Bitrix\Iblock;

class TableViewsComponent extends \CBitrixComponent implements Controllerable
{
    protected $request;

    public function configureActions()
    {
        return [];
    }

    public function onPrepareComponentParams($arParams) {
        return $arParams;
    }

    private function checkModules()
    {
        if(!Loader::includeModule('iblock')){
            throw new \Exception("Не загружены модули необходимые для работы компонента");
        }
        return true;
    }

    private function getColumn()
    {
        return [
            ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true],
            ['id' => 'PROCEDURA_NAME', 'name' => 'Процедура', 'sort' => 'PROCEDURA_NAME', 'default' => true],
            ['id' => 'DOCTORS_NAME', 'name' => 'Врач', 'sort' => 'DOCTORS_NAME', 'default' => true],
        ];
    }

    private function getList($page = 1, $limit = 1)
    {
        $offset = $limit * ($page-1);
        $list = [];
        
        $result = HospitalClientsTable::getList([
            'select' => [
                '*',
                'PROCEDURA_NAME' => 'PROCEDURA.ELEMENT.NAME',
                'DOCTORS_NAME'=> 'DOCTORS.ELEMENT.NAME'
            ],
            'limit' => $limit,
            'offset' => $offset
        ])->fetchCollection();

        foreach($result as $item) {
            $list[] = [
                'data' => [
                    'ID' => $item->getId(),
                    'PROCEDURA_NAME' => $item->get('PROCEDURA_NAME'),
                    'DOCTORS_NAME' => $item->get('DOCTORS_NAME'),
                ]
            ];
        }
    
        return $list;
    }

    public function executeComponent() {
        try {
            $this->checkModules();
            $this->request = Application::getInstance()->getContext()->getRequest();
    
            // Debug output
            echo '<pre>';
            print_r($this->arResult['GRID_DATA']);
            echo '</pre>';
    
            // Or using Bitrix debug
            \Bitrix\Main\Diag\Debug::dump($this->arResult['GRID_DATA']);
            
            // Or write to log file
            \Bitrix\Main\Diag\Debug::writeToFile($this->arResult['GRID_DATA'], "Grid Data Check", "__myfolder/log.txt");
    
            $this->IncludeComponentTemplate();
        }
        catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

}
