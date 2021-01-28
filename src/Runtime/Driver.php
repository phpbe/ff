<?php

namespace Be\Ff\Runtime;


/**
 *  运行时
 *
 * @package Be\Ff\Runtime
 */
class Driver extends \Be\F\Runtime\Driver
{

    protected $frameworkName = 'Ff'; // 框架名称 Mf/Sf/Ff

    public function execute()
    {
        $httpServer = new HttpServer();
        $httpServer->start();
    }

}
