<?php

namespace AadminCore\Core;

class Request implements \Serializable
{
    /**
     * @var string
     */
    protected $actionName;

    /**
     * @var RequestParam
     */
    protected $param;

    /**
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
    }

    /**
     * @return RequestParam
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param RequestParam $param
     */
    public function setParam($param)
    {
        $this->param = $param;
    }

    protected function getSerializeValMap()
    {
        return [
            'actionName',
            'param',
        ];
    }

    public function serialize()
    {
        $arr = [];
        foreach ($this->getSerializeValMap() as $item) {
            $arr[$item] = $this->$item;
        }

        return serialize($arr);
    }

    public function unserialize($serialized)
    {
        $arr = unserialize($serialized);

        foreach ($this->getSerializeValMap() as $item) {
            $this->$item = $arr[$item];
        }
    }
}
