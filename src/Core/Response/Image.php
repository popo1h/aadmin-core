<?php

namespace AadminCore\Core\Response;

use AadminCore\Core\Response;
use AadminCore\Core\ResponseOutput;

class Image extends Response
{
    /**
     * @var string
     */
    protected $imageContent;

    /**
     * @param string $imageContent
     */
    public function setImageContent($imageContent)
    {
        $this->imageContent = $imageContent;
    }

    public function output($application)
    {
        $responseOutput = new ResponseOutput();

        $responseOutput->setContent($this->imageContent);

        $header = [];
        $header['Content-Type'] = 'image/jpg';
        $responseOutput->setHeaders($header);

        return $responseOutput;
    }

    protected function getSerializeValMap()
    {
        $serializeValMap = parent::getSerializeValMap();

        $serializeValMap[] = 'imageContent';

        return $serializeValMap;
    }
}
