<?php

namespace UserTypes;
use Models\Lists\DocsPropertyValuesTable as DocsTable;

class IBreserve
{
    private static function printProcedures($arProperty){
        $docs = DocsTable::getList([      
            'select' => [
                'ID' => 'IBLOCK_ELEMENT_ID',
                'NAME' => 'ELEMENT.NAME',
                'PROCEDURA_ID',
            ],
                'filter' => [
                    'IBLOCK_ELEMENT_ID' => $arProperty['ELEMENT_ID']
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
                    
                $strResult .= '<span class="procedure-link" id="proc_'.$procId.'" onclick="BX.PopupWindowManager.create(\'popup-'.$procId.'\', this, {
                                    width: 400,
                    height: 200,
                    zIndex: 100,
                    closeIcon: true,
                    titleBar: \'Запись на процедуру\',
                    closeByEsc: true,
                    content: `<div class="popup-content">
                        <div>Процедура: ' . htmlspecialchars($proceduraList[$procId]) . '</div>
                        <div style="margin-top: 20px;">
                            <input type="text" id="name_'.$procId.'" placeholder="ФИО" style="width: 100%; margin-bottom: 10px;">
                            <input type="datetime-local" id="time_'.$procId.'" style="width: 100%; margin-bottom: 10px;">
                            <button onclick="addReservation('.$procId.')" class="ui-btn ui-btn-primary">Добавить</button>
                        </div></div>
                }).show();">' 
                          . $proceduraList[$procId] . '</span><br>';
            }
        }
        $strResult .= '</div>';
    
        $strResult .= '
        <script>
            function addReservation(procId) {
                var name = document.getElementById("name_" + procId).value;
                var time = document.getElementById("time_" + procId).value;
                if(name && time) {
                    alert("Данные записи:\nФИО: " + name + "\nВремя: " + time);
                } else {
                    alert("Заполните все поля");
                }
            }
        </script>
        <style>
            .procedure-link {
                cursor: pointer;
                color: #2067b0;
                text-decoration: underline;
            }
            .procedure-link:hover {
                text-decoration: none;
            }
        </style>';
    
        return $strResult;
    }
    
        

    public static function GetUserTypeDescription()
    {
        \Bitrix\Main\UI\Extension::load(['popup']);
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

    public static function GetSearchContent($arProperty, $value, $strHTMLControlName)
    {
        if (trim($value['VALUE']) != '') {
            return $value['VALUE'] . ' ' . $value['DESCRIPTION'];
        }

        return '';
    }

    public static function GetPropertyFieldHtml($arProperty, $arValue, $strHTMLControlName)
    {
        return self::printProcedures($arProperty);
    }
    
    public static function GetAdminListViewHTML($arProperty, $arValue, $strHTMLControlName)
    {
        return self::printProcedures($arProperty);
    }
    
    public static function GetPublicViewHTML($arProperty, $arValue, $strHTMLControlName)
    {
        return self::printProcedures($arProperty);
    }
    
}

