<?php

namespace Be\Ff\Response;

use Be\Ff\Be;


/**
 * Class Driver
 * @package \Be\F\Response\Driver
 */
class Driver extends \Be\F\Response\Driver
{

    protected $data = []; // 暂存数据

    /**
     * 成功
     *
     * @param string $message 消息
     * @param string $redirectUrl 跳转网址
     * @param int $redirectTimeout 跳转超时时长
     */
    public function success(string $message, string $redirectUrl = null, int $redirectTimeout = 3)
    {
        $this->set('success', true);
        $this->set('message', $message);

        if ($redirectUrl !== null) {
            $this->set('redirectUrl', $redirectUrl);
            if ($redirectTimeout > 0) $this->set('redirectTimeout', $redirectTimeout);
        }

        $request = Be::getRequest();
        if ($request->isAjax()) {
            $this->json();
        } else {
            $this->display('App.System.System.success');
        }
    }

    /**
     * 失败
     *
     * @param string $message 消息
     * @param string $redirectUrl 跳转网址
     * @param int $redirectTimeout 跳转超时时长
     */
    public function error(string $message, string $redirectUrl = null, int $redirectTimeout = 3)
    {
        $this->set('success', false);
        $this->set('message', $message);

        if ($redirectUrl !== null) {
            $this->set('redirectUrl', $redirectUrl);
            if ($redirectTimeout > 0) $this->set('redirectTimeout', $redirectTimeout);
        }

        $request = Be::getRequest();
        if ($request->isAjax()) {
            $this->json();
        } else {
            $this->display('App.System.System.error');
        }
    }

    /**
     * 系统异常
     *
     * @param \Throwable $e 错误码
     */
    public function exception(\Throwable $e)
    {
        $request = Be::getRequest();
        if ($request->isAjax()) {
            $this->set('success', false);
            $this->set('message', $e->getMessage());
            $this->set('trace', $e->getTrace());
            $this->set('code', $e->getCode());
            $this->json();
        } else {
            $this->set('e', $e);
            $this->display('App.System.System.exception');
        }
    }

    /**
     * 记录历史节点
     *
     * @param string $historyKey 历史节点键名
     */
    public function createHistory(string $historyKey = null)
    {
        $request = Be::getRequest();
        if ($historyKey === null) {
            $historyKey = $request->getAppName() . '.' . $request->getControllerName();
        }

        $session = Be::getSession();
        $session->set('_history_url_'.$historyKey, $request->server('REQUEST_URI'));
        $session->set('_history_post_'.$historyKey, serialize($request->post()));
    }

    /**
     * 成功
     *
     * @param string $message 消息
     * @param string $historyKey 历史节点键名
     * @param int $redirectTimeout 跳转超时时长
     */
    public function successAndBack(string $message, string $historyKey = null, int $redirectTimeout = 3)
    {
        $request = Be::getRequest();
        if ($historyKey === null) {
            $historyKey = $request->getAppName() . '.' . $request->getControllerName();
        }

        $this->set('success', true);
        $this->set('message', $message);
        $this->set('historyKey', $historyKey);

        $session = Be::getSession();
        $historyUrl = null;
        if ($session->has('_history_url_'.$historyKey)) {
            $historyUrl = $session->get('_history_url_'.$historyKey);
        }
        if (!$historyUrl) $historyUrl = $request->server('HTTP_REFERER');
        if (!$historyUrl) $historyUrl = './';

        $historyPost = null;
        if ($session->has('_history_post_'.$historyKey)) {
            $historyPost = $session->get('_history_post_'.$historyKey);
            if ($historyPost) $historyPost = unserialize($historyPost);
        }

        $this->set('historyUrl', $historyUrl);
        $this->set('historyPost', $historyPost);
        $this->set('redirectTimeout', $redirectTimeout);
        $this->display('App.System.System.successAndBack');
    }

    /**
     * 失败
     *
     * @param string $message 消息
     * @param string $historyKey 历史节点键名
     * @param int $redirectTimeout 跳转超时时长
     */
    public function errorAndBack(string $message, string $historyKey = null, int $redirectTimeout = 3)
    {
        $request = Be::getRequest();
        if ($historyKey === null) {
            $historyKey = $request->getAppName() . '.' . $request->getControllerName();
        }

        $this->set('success', false);
        $this->set('message', $message);
        $this->set('historyKey', $historyKey);

        $session = Be::getSession();
        $historyUrl = null;
        if ($session->has('_history_url_'.$historyKey)) {
            $historyUrl = $session->get('_history_url_'.$historyKey);
        }
        if (!$historyUrl) $historyUrl = $request->server('HTTP_REFERER');
        if (!$historyUrl) $historyUrl = './';

        $historyPost = null;
        if ($session->has('_history_post_'.$historyKey)) {
            $historyPost = $session->get('_history_post_'.$historyKey);
            if ($historyPost) $historyPost = unserialize($historyPost);
        }

        $this->set('historyUrl', $historyUrl);
        $this->set('historyPost', $historyPost);
        $this->set('redirectTimeout', $redirectTimeout);
        $this->display('App.System.System.errorAndBack');
    }

    /**
     * 显示模板
     *
     * @param string $template 模板名
     * @param string $theme 主题名
     */
    public function display(string $template = null, string $theme = null)
    {
        if ($template === null) {
            $template = 'App.' . Be::getRequest()->getRoute();
        }

        $this->response->end($this->fetch($template, $theme));
    }

    /**
     * 获取模板内容
     *
     * @param string $template 模板名
     * @param string $theme 主题名
     * @return  string
     */
    public function fetch(string $template, string $theme = null)
    {
        ob_start();
        ob_clean();
        $templateInstance = Be::getTemplate($template, $theme);
        foreach ($this->data as $key => $val) {
            $templateInstance->$key = $val;
        }
        $templateInstance->display();
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}
