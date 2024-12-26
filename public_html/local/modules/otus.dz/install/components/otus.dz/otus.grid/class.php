<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

/** @global CIntranetToolbar $INTRANET_TOOLBAR */

// global $INTRANET_TOOLBAR;
// use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Context,	
	Bitrix\Main\Application,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Engine\Contract\Controllerable,
	Bitrix\Iblock;
use Bitrix\Main\Engine\Contract;
use Bitrix\Currency\CurrencyTable as Currency;



class TableViewsComponent extends \CBitrixComponent
{

    protected $request;

    /**
     * Подготовка параметров компонента
     * @param $arParams
     * @return mixed
    */
    public function onPrepareComponentParams($arParams) {
       // тут пишем логику обработки параметров, дополнение к параметрам по умолчанию
       return $arParams;
    }


    /**
     * Проверка наличия модулей требуемых для работы компонента
     * @return bool
     * @throws Exception
    */
    private function checkModules()
    {
        if(!Loader::includeModule('iblock') || !Loader::includeModule('currency')){
            throw new \Exception("Не загружены модули необходимые для работы компонента");
        }
        return true;
    }


    private function getColumn()
    {
        $fieldMap = Currency::getMap();
        $columns = [];
        foreach ($fieldMap as $key => $field) {
            $columns[] = array(
                'id' => $field->getName(),
                'name' => $field->getTitle()
            );
        }
        return $columns;
    }


    private function getList($page = 1, $limit = 1)
    {
        $offset = $limit * ($page-1);
        $list = [];
        $data = Currency::getList([
            'select' => ['CURRENCY'],
            'filter' => [], 
            'limit' => $limit,
            'offset' =>$offset
        ]);
        
        while ($item = $data->fetch()) {
            $list[] = array('data' => $item);
        }
    
        return $list;
    }


    /**
     * Точка входа в компонент
     * Должна содержать только последовательность вызовов вспомогательых ф-ий и минимум логики
     * всю логику стараемся разносить по классам и методам 
     */
    public function executeComponent() {

        try
        {
            $this->checkModules(); // проверяем подключение модулей

            // получаем параметры методов GET и POST, из обьекта request который позволяет получить данные о текущем запросе: метод и протокол, запрошенный URL, переданные параметры
            $this->$request = Application::getInstance()->getContext()->getRequest();

            if(isset($this->$request['report_list'])){
                $page = explode('page-', $this->$request['report_list']);
                $page = $page[1];
            }else{
                $page = 1;
            }

            $this->arResult['COLUMNS'] = $this->getColumn(); // получаем названия полей таблицы
            $this->arResult['LISTS'] = $this->getList($page, $this->arParams['NUM_PAGE']); // получаем записи таблицы
            $this->arResult['COUNT'] =  Currency::getCount(); // количество записей
         

            // подключаем шаблон
            $this->IncludeComponentTemplate();

        }
        catch (SystemException $e)
        {
            ShowError($e->getMessage());
        }

    }


}