<?php
namespace Secondo\Logger;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ClientLogger {
    public Logger $logger;
    public function __construct() {
        $this->logger = new Logger("[Secondo]: ");
        $this->logger->pushHandler(new StreamHandler("php://stdout", Logger::INFO));
    }
}