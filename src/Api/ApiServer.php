<?php

namespace AadminCore\Api;

use AadminCore\Core\Action;
use AadminCore\Core\Request;
use AadminCore\Exceptions\AadminCoreException;

class ApiServer
{
    /**
     * @var Action[]
     */
    protected $actions;

    /**
     * @var Net
     */
    protected $net;

    /**
     * @param Net $net
     */
    public function __construct(Net $net)
    {
        $this->actions = [];
        $this->net = $net;
    }

    /**
     * @param Action $action
     */
    public function registerAction($action)
    {
        if ($action instanceof Action) {
            $this->actions[$action->getName()] = $action;
        }
    }

    /**
     * @param Action[] $actionArr
     */
    public function registerActions($actionArr)
    {
        foreach ($actionArr as $action) {
            $this->registerAction($action);
        }
    }

    /**
     * @param string $actionName
     * @return Action
     * @throws AadminCoreException
     */
    public function getAction($actionName)
    {
        if (!isset($this->actions[$actionName])) {
            throw (new AadminCoreException('can not found the action'));
        }

        return $this->actions[$actionName];
    }

    /**
     * @return Action[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    public function registerInterceptor()
    {
    }

    /**
     * @return string
     */
    public function listen()
    {
        $requestStr = $this->net->receive();
        $request = unserialize($requestStr);
        $action_name = $request->getActionName();

        $action = $this->getAction($action_name);

        $response = $action->doAction($request->getParam());

        return $this->net->respond(serialize($response));
    }
}
