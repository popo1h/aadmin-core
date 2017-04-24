<?php

namespace AadminCore\Core;

use AadminCore\Foundation\Application;

abstract class Response implements \Serializable
{
    /**
     * @var RequestInfo
     */
    protected $requestInfo;

    /**
     * @param Application $application
     * @return ResponseOutput
     */
    abstract public function output($application);

    /**
     * @return RequestInfo
     */
    public function getRequestInfo()
    {
        return $this->requestInfo;
    }

    /**
     * @param RequestInfo $requestInfo
     */
    public function setRequestInfo($requestInfo)
    {
        $this->requestInfo = $requestInfo;
    }

    protected function getSerializeValMap()
    {
        return [];
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
