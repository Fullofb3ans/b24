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
    
            // Static data for testing
            $this->arResult['GRID_DATA'] = [
                'GRID_ID' => 'test_grid',
                'COLUMNS' => [
                    ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true],
                    ['id' => 'NAME', 'name' => 'Name', 'sort' => 'NAME', 'default' => true],
                    ['id' => 'AGE', 'name' => 'Age', 'sort' => 'AGE', 'default' => true],
                ],
                'ROWS' => [
                    [
                        'data' => [
                            'ID' => 1,
                            'NAME' => 'John Doe',
                            'AGE' => 25,
                        ]
                    ],
                    [
                        'data' => [
                            'ID' => 2,
                            'NAME' => 'Jane Smith',
                            'AGE' => 30,
                        ]
                    ],
                    [
                        'data' => [
                            'ID' => 3,
                            'NAME' => 'Bob Johnson',
                            'AGE' => 35,
                        ]
                    ],
                ],
                'SHOW_ROW_CHECKBOXES' => true,
                'AJAX_MODE' => 'Y',
                'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
                'AJAX_OPTION_JUMP' => 'N',
                'SHOW_CHECK_ALL_CHECKBOXES' => true,
                'SHOW_ROW_ACTIONS_MENU' => true,
                'SHOW_GRID_SETTINGS_MENU' => true,
                'SHOW_PAGINATION' => true,
                'SHOW_SELECTED_COUNTER' => true,
                'SHOW_TOTAL_COUNTER' => true,
                'TOTAL_ROWS_COUNT' => 3,
            ];
    
            $this->IncludeComponentTemplate();
        }
        catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }
}
