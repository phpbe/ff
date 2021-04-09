<?php

namespace Be\Ff;

use Be\F\Config\ConfigFactory;
use Be\F\Lib\LibFactory;
use Be\F\Log\LogFactory;
use Be\F\Property\PropertyFactory;
use Be\F\Request\RequestFactory;
use Be\F\Response\ResponseFactory;
use Be\F\Runtime\RuntimeFactory;
use Be\F\Runtime\RuntimeException;
use Be\F\Session\SessionFactory;
use Be\F\Template\TemplateFactory;
use Be\F\App\ServiceFactory;

/**
 *  BE系统资源工厂
 * @package Be\Mf
 *
 */
abstract class Be
{

    /**
     * 获取运行时对象
     *
     * @return \Be\F\Runtime\Driver
     */
    public static function getRuntime()
    {
        return RuntimeFactory::getInstance();
    }

    /**
     * 获取请求对象
     *
     * @return \Be\F\Request\Driver
     */
    public static function getRequest()
    {
        return RequestFactory::getInstance();
    }

    /**
     * 获取输出对象
     *
     * @return \Be\F\Response\Driver
     */
    public static function getResponse()
    {
        return ResponseFactory::getInstance();
    }

    /**
     * 获取指定的配置文件
     *
     * @param string $name 配置文件名
     * @return mixed
     */
    public static function getConfig($name)
    {
        return ConfigFactory::getInstance($name);
    }

    /**
     * 新创建一个指定的配置文件
     *
     * @param string $name 配置文件名
     * @return mixed
     */
    public static function newConfig($name)
    {
        return ConfigFactory::newInstance($name);
    }

    /**
     * 获取日志记录器
     *
     * @return \Be\F\Log\Driver
     */
    public static function getLog()
    {
        return LogFactory::getInstance();
    }

    /**
     * 获取一个属性
     *
     * @param string $name 名称
     * @return \Be\F\Property\Driver
     * @throws RuntimeException
     */
    public static function getProperty($name)
    {
        return PropertyFactory::getInstance($name);
    }


    /**
     * 获取SESSION
     *
     * @return \Be\F\Session\Driver
     */
    public static function getSession()
    {
        return SessionFactory::getInstance();
    }

    /**
     * 获取指定的一个服务
     *
     * @param string $name 服务名
     * @return mixed
     */
    public static function getService($name)
    {
        return ServiceFactory::getInstance($name);
    }

    /**
     * 新创建一个服务
     *
     * @param string $name 服务名
     * @return mixed
     */
    public static function newService($name)
    {
        return ServiceFactory::newInstance($name);
    }

    /**
     * 获取指定的库
     *
     * @param string $name 库名，可指定命名空间，调用第三方库
     * @return mixed
     * @throws RuntimeException
     */
    public static function getLib($name)
    {
        return LibFactory::getInstance($name);
    }

    /**
     * 新创建一个指定的库
     *
     * @param string $name 库名，可指定命名空间，调用第三方库
     * @return mixed
     * @throws RuntimeException
     */
    public static function newLib($name)
    {
        return LibFactory::newInstance($name);
    }

    /**
     * 获取指定的一个模板
     *
     * @param string $template 模板名
     * @param string $theme 主题名
     * @return \Be\F\Template\Driver
     * @throws RuntimeException
     */
    public static function getTemplate($template, $theme = null)
    {
        return TemplateFactory::getInstance($template, $theme);
    }

    /**
     * 获取当前用户
     *
     * @return object
     */
    public static function getUser()
    {
        return Be::getSession()->get('_user');
    }

    /**
     * 回收资源
     */
    public static function release()
    {
        foreach ([
                     '\\Be\\F\\Request\\RequestFactory',
                     '\\Be\\F\\Response\\ResponseFactory',
                     '\\Be\\F\\Log\\LogFactory',
                     '\\Be\\F\\Session\\SessionFactory',
                     '\\Be\\F\\App\\ServiceFactory',
                     '\\Be\\F\\Lib\\LibFactory',
                     '\\Be\\F\\Template\\TemplateFactory',

                     '\\Be\\F\\Redis\\RedisFactory',
                 ] as $factoryClass) {
            $factoryClass::release();
        }
    }
}
