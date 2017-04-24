<?php

namespace AadminCore\Core\Response;

use AadminCore\Core\Response;
use AadminCore\Core\ResponseOutput;

class Json extends Response
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function output($application)
    {
        $content = json_encode($this->data);

        $responseOutput = new ResponseOutput();
        $responseOutput->setHeaders([
            'Content-Type' => 'application/json',
        ]);
        $responseOutput->setContent($content);

        return $responseOutput;
    }

    protected function getSerializeValMap()
    {
        $serializeValMap = parent::getSerializeValMap();

        $serializeValMap[] = 'data';

        return $serializeValMap;
    }
}
