<?php
/* created by Sufi Dec 2017 */
namespace App;

use Illuminate\Support\Facades\Log;
use Monolog\Handler\RotatingFileHandler;

class TCPLog
{
    public static function setup($path){
        $monolog = Log::getLogger();

        $rotate = new RotatingFileHandler($path); //'app/tcpapp.log'
        $rotate->setFilenameFormat('{filename}_{date}','Ymd');

        $monolog->pushHandler($rotate);

        return $monolog;
    }
}
