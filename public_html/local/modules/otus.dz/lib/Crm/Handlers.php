<?php
namespace Otus\Homework\Crm;

class Handlers{ 
    public static function updateTabs(Event $event): EventResult
    {
$tabs = $event->getParameter('tabs');
$tabs[] = [
    'id'=>'custom',
    'name'=> 'custom'
];
return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [['tabs'=>$tabs]]);
    }
}