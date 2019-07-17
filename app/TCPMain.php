<?php
/* created by Sufi Dec 2017 */
namespace App;

use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\TcpServer;
//use Illuminate\Support\Facades\Log;
//use Monolog\Handler\RotatingFileHandler;
use App\TCPLog;

class TCPMain
{
    public static function start()
    {
        //$log = Logger::getLogger('tcpLog');
        //$log = self::setupLog();
        $log = TCPLog::setup('app/tcpapp.log');

        $loop = Factory::create();
        $server = new TcpServer("0.0.0.0:9811",$loop);

        $server->on('connection', function (ConnectionInterface $conn) use ($log) {
            echo 'Connected to ' . $conn->getRemoteAddress() . PHP_EOL;
            $log->info('Connected to ' . $conn->getRemoteAddress());
            $remAddr = $conn->getRemoteAddress();
            $conn->on('data', function ($chunk) use ($conn,$log,$remAddr) { //
                //echo $chunk;
                $log->info('From ->' . $remAddr .  ': Received :-' . $chunk);
                $conn->write('Send Data :'. '1223334459595');
            });

            $conn->on('end', function () use ($log,$remAddr) {
                echo 'Socket closed ->' . $remAddr . PHP_EOL;
                $log->info('Socket closed -> '. $remAddr) ;
            });
        });

        $server->on('error', function (Exception $e) use ($log) { //
            $log->error($e->getMessage());
        });

        echo 'Listening on ' . $server->getAddress() . PHP_EOL;
        $log->info('Server started at ' . $server->getAddress());

        $loop->run();
    }
}
