<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

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
    
            if(isset($this->request['report_list'])){
                $page = explode('page-', $this->request['report_list']);
                $page = $page[1];
            }else{
                $page = 1;
            }
    
            // Prepare grid data
            $this->arResult['GRID_DATA'] = [
                'GRID_ID' => 'hospital_clients_grid',
                'COLUMNS' => $this->getColumn(),
                'ROWS' => $this->getList($page, $this->arParams['NUM_PAGE']),
                'NAV_OBJECT' => new \Bitrix\Main\UI\PageNavigation('report_list'),
                'AJAX_MODE' => 'Y',
                'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
                'AJAX_OPTION_JUMP' => 'N',
                'SHOW_ROW_CHECKBOXES' => true,
                'SHOW_CHECK_ALL_CHECKBOXES' => true,
                'SHOW_ROW_ACTIONS_MENU' => true,
                'SHOW_GRID_SETTINGS_MENU' => true,
                'SHOW_NAVIGATION_PANEL' => true,
                'SHOW_PAGINATION' => true,
                'SHOW_SELECTED_COUNTER' => true,
                'SHOW_TOTAL_COUNTER' => true,
                'TOTAL_ROWS_COUNT' => $this->arResult['COUNT'],
            ];
    
            $this->IncludeComponentTemplate();
        }
        catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }
}
