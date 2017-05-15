<?php

namespace AadminCore\Core\Response;

use AadminCore\Core\Response;
use AadminCore\Core\ResponseOutput;

class Download extends Response
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $fileContent;

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param string $fileContent
     */
    public function setFileContent($fileContent)
    {
        $this->fileContent = $fileContent;
    }

    public function output($application)
    {
        $responseOutput = new ResponseOutput();

        $responseOutput->setContent($this->fileContent);

        $header = [];
        $header['Content-Type'] = 'application/octet-stream';
        $header['Content-Disposition'] = 'attachment; filename="' . $this->filename . '"';
        $responseOutput->setHeaders($header);

        return $responseOutput;
    }

    protected function getSerializeValMap()
    {
        $serializeValMap = parent::getSerializeValMap();

        $serializeValMap[] = 'filename';
        $serializeValMap[] = 'fileContent';

        return $serializeValMap;
    }
}
