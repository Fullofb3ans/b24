<?php

namespace UserTypes;
use Models\Lists\DocsPropertyValuesTable as DocsTable;

class IBreserve
{
    public static function GetUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE'        => 'S', // тип поля
            'USER_TYPE'            => 'iblock_reserve', // код типа пользовательского свойства
            'DESCRIPTION'          => 'бронь процедуры', // название типа пользовательского свойства
            'GetPropertyFieldHtml' => array(self::class, 'GetPropertyFieldHtml'), // метод отображения свойства
            'GetSearchContent' => array(self::class, 'GetSearchContent'), // метод поиска
            'GetAdminListViewHTML' => array(self::class, 'GetAdminListViewHTML'),  // метод отображения значения в списке
            'GetPublicEditHTML' => array(self::class, 'GetPropertyFieldHtml'), // метод отображения значения в форме редактирования
            'GetPublicViewHTML' => array(self::class, 'GetPublicViewHTML'), // метод отображения значения
        );
    }


    public static function PrepareSettings($arFields)
    {
        // return array("_BLANK" => ($arFields["USER_TYPE_SETTINGS"]["_BLANK"] == "Y" ? "Y" : "N"));
        if(is_array($arFields["USER_TYPE_SETTINGS"]) && $arFields["USER_TYPE_SETTINGS"]["_BLANK"] == "Y"){
            return array("_BLANK" =>  "Y");
        }else{
            return array("_BLANK" =>  "N");
        }
    }

   
    public static function GetPublicViewHTML($arProperty, $arValue, $strHTMLControlName)
    {
        $arSettings = self::PrepareSettings($arProperty);

        $arVals = array();
        if (!is_array($arProperty['VALUE'])) {
            $arProperty['VALUE'] = array($arProperty['VALUE']);
            $arProperty['DESCRIPTION'] = array($arProperty['DESCRIPTION']);
        }
        foreach ($arProperty['VALUE'] as $i => $value) {
            $arVals[$value] = $arProperty['DESCRIPTION'][$i];
        }

        $strResult = '';
        $strResult = '<a ' . ($arSettings["_BLANK"] == 'Y' ? 'target="_blank"' : '') . ' href="' . trim($arValue['VALUE']) . '">' . (trim($arVals[$arValue['VALUE']]) ? trim($arVals[$arValue['VALUE']]) : trim($arValue['VALUE'])) . '</a>';
        return $strResult;
    }


    public static function GetAdminListViewHTML($arProperty, $arValue, $strHTMLControlName)
    {
        $arSettings = self::PrepareSettings($arProperty);

        $strResult = '';
        $strResult = '<a ' . ($arSettings["_BLANK"] == 'Y' ? 'target="_blank"' : '') . ' href="' . trim($arValue['VALUE']) . '">' . (trim($arValue['DESCRIPTION']) ? trim($arValue['DESCRIPTION']) : trim($arValue['VALUE'])) . '</a>';
        return $strResult;
    }


    public static function GetSearchContent($arProperty, $value, $strHTMLControlName)
    {
        if (trim($value['VALUE']) != '') {
            return $value['VALUE'] . ' ' . $value['DESCRIPTION'];
        }

        return '';
    }

    public static function GetPropertyFieldHtml($arProperty, $arValue, $strHTMLControlName)
    {
    
        $doctorId = $arProperty['IBLOCK_ELEMENT_ID'];
    
        $docs = DocsTable::getList([      
            'select' => [
                'ID' => 'IBLOCK_ELEMENT_ID',
                'NAME' => 'ELEMENT.NAME',
                'PROCEDURA_ID',
            ],
            'filter' => [
                'IBLOCK_ELEMENT_ID' => $doctorId
            ]
        ])->fetch();
    
        $proceduresAll = \Bitrix\Iblock\Elements\ElementProcTable::query()
            ->addSelect('NAME')
            ->addSelect('ID')
            ->fetchCollection();
    
        $proceduraList = [];
        foreach($proceduresAll as $procedura){
            $proceduraList[$procedura->getId()] = $procedura->getName();
        }
    
        $strResult = '<div class="procedures-text">';
        if ($docs && isset($docs['PROCEDURA_ID'])) {
            foreach($docs['PROCEDURA_ID'] as $procId) {
                $strResult .= $proceduraList[$procId] . '<br>';
            }
        }
        $strResult .= '</div>';
    
        return $strResult;
    }
}

