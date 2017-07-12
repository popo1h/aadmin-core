<?php

namespace AadminCore\Foundation;

use AadminCore\Api\Net;
use AadminCore\Api\Net\Http;
use AadminCore\View\TemplateBaseData;

class Config
{
    /**
     * [ 'cate_name' => [ 'url' => 'server_url', 'host_ips' => null|[ 'ip', 'ip' ] ]
     * @var array
     */
    private $serverMap;

    /**
     * @var string
     */
    private $clientServerBaseUrl;

    /**
     * @var string
     */
    private $baseTemplatePath;

    /**
     * @var string
     */
    private $baseTemplateName;

    /**
     * @var string
     */
    private $localTemplatePath;

    /**
     * @var TemplateBaseData
     */
    private $templateBaseData;

    /**
     * @var string
     */
    private $cachePath;

    /**
     * aadmin base static file's base url
     * @var string
     */
    private $staticBaseUrl;

    /**
     * @var Net
     */
    private $net;

    /**
     * @param string $cachePath
     * @param Net $net
     */
    public function __construct($cachePath, $baseTemplatePath, $baseTemplateName, $net = null)
    {
        $this->cachePath = $cachePath;
        $this->baseTemplatePath = $baseTemplatePath;
        $this->baseTemplateName = $baseTemplateName;

        if (!isset($net)) {
            $net = new Http();
        }
        $this->net = $net;
    }

    /**
     * @return array
     */
    public function getServerMap()
    {
        return $this->serverMap;
    }

    /**
     * @param array $serverMap
     */
    public function setServerMap($serverMap)
    {
        $this->serverMap = $serverMap;
    }

    /**
     * @return string
     */
    public function getClientServerBaseUrl()
    {
        return $this->clientServerBaseUrl;
    }

    /**
     * @param string $clientServerBaseUrl
     */
    public function setClientServerBaseUrl($clientServerBaseUrl)
    {
        $this->clientServerBaseUrl = $clientServerBaseUrl;
    }

    /**
     * @return string
     */
    public function getBaseTemplatePath()
    {
        return $this->baseTemplatePath;
    }

    /**
     * @return string
     */
    public function getBaseTemplateName()
    {
        return $this->baseTemplateName;
    }

    /**
     * @return string
     */
    public function getLocalTemplatePath()
    {
        return $this->localTemplatePath;
    }

    /**
     * @param string $localTemplatePath
     */
    public function setLocalTemplatePath($localTemplatePath)
    {
        $this->localTemplatePath = $localTemplatePath;
    }

    /**
     * @return TemplateBaseData
     */
    public function getTemplateBaseData()
    {
        if (!isset($this->templateBaseData)) {
            $this->templateBaseData = new TemplateBaseData();
        }
        return $this->templateBaseData;
    }

    /**
     * @param TemplateBaseData $templateBaseData
     */
    public function setTemplateBaseData($templateBaseData)
    {
        $this->templateBaseData = $templateBaseData;
    }

    /**
     * @return string
     */
    public function getCachePath()
    {
        return $this->cachePath;
    }

    /**
     * @return string
     */
    public function getStaticBaseUrl()
    {
        return $this->staticBaseUrl;
    }

    /**
     * @param string $staticBaseUrl
     */
    public function setStaticBaseUrl($staticBaseUrl)
    {
        $this->staticBaseUrl = $staticBaseUrl;
    }

    /**
     * @return Net
     */
    public function getNet()
    {
        return $this->net;
    }
}
