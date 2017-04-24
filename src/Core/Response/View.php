<?php

namespace AadminCore\Core\Response;

use AadminCore\Core\Response;
use AadminCore\Core\ResponseOutput;
use AadminCore\Exceptions\AadminCoreException;

class View extends Response
{
    /**
     * @var string
     */
    protected $templateName;

    /**
     * @var array
     */
    protected $templateData = [];

    /**
     * @param string $templateName
     */
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * @param array $templateData
     */
    public function setTemplateData($templateData)
    {
        $this->templateData = $templateData;
    }

    public function output($application)
    {
        if (!isset($this->requestInfo)) {
            throw (new AadminCoreException('request error'));
        }

        $cateName = $this->requestInfo->getCateName();
        if (!isset($cateName)) {
            $cateName = '__local__';
        }
        $application->templateLoader->setMainNamespace($cateName);
        $baseDataArr = $application->templateBaseData->toArray($this->requestInfo);

        $content = $application->template->render($this->templateName, array_merge($this->templateData, $baseDataArr));

        $responseOutput = new ResponseOutput();
        $responseOutput->setContent($content);

        return $responseOutput;
    }

    protected function getSerializeValMap()
    {
        $serializeValMap = parent::getSerializeValMap();

        $serializeValMap[] = 'templateName';
        $serializeValMap[] = 'templateData';

        return $serializeValMap;
    }
}
