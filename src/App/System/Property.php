<?php

namespace Be\Ff\App\System;


class Property extends \Be\F\App\Property
{

    protected $label = '系统';
    protected $icon = 'el-icon-s-tools';

    public function __construct() {
        parent::__construct(__FILE__);
    }

}
