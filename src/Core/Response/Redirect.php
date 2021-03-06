<?php

namespace AadminCore\Core\Response;

use AadminCore\Core\Response;
use AadminCore\Core\ResponseOutput;

class Redirect extends Response
{
    /**
     * @var string
     */
    protected $redirectUrl;

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    public function output($application)
    {
        $responseOutput = new ResponseOutput();
        $responseOutput->setStatusCode(302);
        $responseOutput->setHeaders([
            'Location' => $this->redirectUrl,
        ]);

        return $responseOutput;
    }

    protected function getSerializeValMap()
    {
        $serializeValMap = parent::getSerializeValMap();

        $serializeValMap[] = 'redirectUrl';

        return $serializeValMap;
    }
}