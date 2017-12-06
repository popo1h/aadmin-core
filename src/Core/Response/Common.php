<?php

namespace AadminCore\Core\Response;

use AadminCore\Core\Response;
use AadminCore\Core\ResponseOutput;

class Common extends Response
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var array [ 'header_name' => 'header_content' ]
     */
    protected $headers;

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function output($application)
    {
        $responseOutput = new ResponseOutput();

        $responseOutput->setContent($this->content);
        $responseOutput->setHeaders($this->headers);

        return $responseOutput;
    }

    protected function getSerializeValMap()
    {
        $serializeValMap = parent::getSerializeValMap();

        $serializeValMap[] = 'headers';
        $serializeValMap[] = 'content';

        return $serializeValMap;
    }
}
