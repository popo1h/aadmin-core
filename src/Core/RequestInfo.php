<?php

namespace AadminCore\Core;

class RequestInfo
{
    /**
     * @var string
     */
    private $cateName;

    /**
     * @var string
     */
    private $actionName;

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var RequestParam
     */
    private $param;

    /**
     * @return string
     */
    public function getCateName()
    {
        return $this->cateName;
    }

    /**
     * @param string $cateName
     */
    public function setCateName($cateName)
    {
        $this->cateName = $cateName;
    }

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
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
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
}
