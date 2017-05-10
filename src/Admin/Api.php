<?php

namespace AadminCore\Admin;

use AadminCore\Core\Action;
use AadminCore\Core\InterceptorInterface;
use AadminCore\Core\RequestInfo;
use AadminCore\Core\RequestParam;
use AadminCore\Exceptions\AadminCoreException;

class Api
{
    const INTERCEPTOR_TYPE_BEFORE_ACTION = 1;

    /**
     * @var \AadminCore\Api\ApiClient
     */
    protected $client;

    /**
     * @var Action[]
     */
    protected $localActions = [];

    /**
     * @var InterceptorInterface[][]
     */
    protected $interceptors = [];

    /**
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param Action $action
     */
    public function registerLocalAction($action)
    {
        if ($action instanceof Action) {
            $this->localActions[$action::getName()] = $action;
        }
    }

    /**
     * @param Action[] $actionArr
     */
    public function registerLocalActions($actionArr)
    {
        foreach ($actionArr as $action) {
            $this->registerLocalAction($action);
        }
    }

    /**
     * @param string $actionName
     * @return Action
     * @throws AadminCoreException
     */
    public function getLocalAction($actionName)
    {
        if (!isset($this->localActions[$actionName])) {
            throw (new AadminCoreException('can not found the action'));
        }

        return $this->localActions[$actionName];
    }

    /**
     * @param int $interceptorType
     * @param InterceptorInterface $interceptor
     */
    public function registerInterceptor($interceptorType, InterceptorInterface $interceptor)
    {
        $this->interceptors[$interceptorType][] = $interceptor;
    }

    /**
     * @return \AadminCore\Core\Response
     * @throws AadminCoreException
     */
    public function listen()
    {
        $cateName = isset($_GET['__aadmin_cate_name']) ? $_GET['__aadmin_cate_name'] : null;
        $actionName = isset($_GET['__aadmin_action_name']) ? $_GET['__aadmin_action_name'] : null;

        if (!isset($actionName)) {
            throw (new AadminCoreException('action name is empty'));
        }

        $get = $_GET;
        unset($get['__aadmin_cate_name']);
        unset($get['__aadmin_action_name']);

        $param = new RequestParam();
        $param->setGet($get);
        $param->setPost($_POST);
        $param->setFileByFiles($_FILES);

        if (isset($this->interceptors[self::INTERCEPTOR_TYPE_BEFORE_ACTION])) {
            $interceptParam = [
                'cateName' => $cateName,
                'actionName' => $actionName,
                'param' => $param,
            ];
            foreach ($this->interceptors[self::INTERCEPTOR_TYPE_BEFORE_ACTION] as $interceptor) {
                $res = $interceptor->intercept($interceptParam);
                if ($res) {
                    return $res;
                }
            }
            $cateName = $interceptParam['cateName'];
            $actionName = $interceptParam['actionName'];
            $param = $interceptParam['param'];
        }

        if (!isset($cateName)) {
            $cateName = '__local__';
        }
        if ($cateName == '__local__') {
            $action = $this->getLocalAction($actionName);

            $response = $action->doAction($param);

            $requestInfo = new RequestInfo();
            $requestInfo->setCateName($cateName);
            $requestInfo->setActionName($actionName);
            $requestInfo->setApiUrl(null);
            $requestInfo->setParam($param);
            $response->setRequestInfo($requestInfo);
        } else {
            $response = $this->client->request($cateName, $actionName, $param);
        }

        return $response;
    }
}
