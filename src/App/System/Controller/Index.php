<?php

namespace Be\Ff\App\System\Controller;

use Be\Ff\Be;


class Index
{

    public function index()
    {
        Be::getResponse()->end('#' . \Swoole\Coroutine::getuid() . ' working...' );
    }

}
