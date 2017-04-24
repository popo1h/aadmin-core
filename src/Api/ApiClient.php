<?php

namespace AadminCore\Api;

use AadminCore\Core\Request;
use AadminCore\Core\RequestInfo;
use AadminCore\Core\RequestParam;
use AadminCore\Core\Response;
use AadminCore\Exceptions\AadminCoreException;

class ApiClient
{
    /**
     * @var Net
     */
    protected $net;

    /**
     * @var string
     */
    protected $serverUrlMap;

    /**
     * @param Net $net
     */
    public function __construct(Net $net, $serverUrlMap)
    {
        $this->net = $net;
        $this->serverUrlMap = $serverUrlMap;
    }

    /**
     * @param string $cateName
     * @param string $actionName
     * @param RequestParam $param
     * @return Response
     * @throws AadminCoreException
     */
    public function request($cateName, $actionName, RequestParam $param)
    {
        $request = new Request();
        $request->setActionName($actionName);
        $request->setParam($param);

        if (!isset($this->serverUrlMap[$cateName])) {
            throw new AadminCoreException('request api error');
        }

        $apiUrl = $this->serverUrlMap[$cateName];

        $responseStr = $this->net->request($apiUrl, serialize($request));
        $response = unserialize($responseStr);

        $requestInfo = new RequestInfo();
        $requestInfo->setCateName($cateName);
        $requestInfo->setActionName($actionName);
        $requestInfo->setApiUrl($apiUrl);
        $requestInfo->setParam($param);
        $response->setRequestInfo($requestInfo);

        return $response;
    }
}
