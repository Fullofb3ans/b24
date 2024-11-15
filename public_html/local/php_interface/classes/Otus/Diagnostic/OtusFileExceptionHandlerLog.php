<?php 
namespace Otus\Diagnostic;

use Bitrix\Main\Diag\FileExceptionHandlerLog;
use Bitrix\Main\Diag\ExceptionHandlerFormatter;

// class OtusFileExceptionHandlerLog extends FileExceptionHandlerLog
// {
//     public function write($exception, $logType){
//         $text = ExceptionHandlerFormatter::format($exception, false, $this->level);

// 		$context = [
// 			'type' => static::logTypeToString($logType),
// 		];

// 		$logLevel = static::logTypeToLevel($logType);

// 		$message = "OTUS {date} - Host: {host} - {type} - {$text}\n";

// 		$this->logger->log($logLevel, $message, $context);
//     }
// };

?>