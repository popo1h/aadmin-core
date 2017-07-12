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
     * @var array
     */
    protected $serverMap;

    /**
     * @param Net $net
     */
    public function __construct(Net $net, $serverMap)
    {
        $this->net = $net;
        $this->serverMap = $serverMap;
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

        if (!isset($this->serverMap[$cateName])) {
            throw new AadminCoreException('request api error');
        }

        $apiUrl = $this->serverMap[$cateName]['url'];
        $hostIps = $this->serverMap[$cateName]['host_ips'];

        $responseStr = $this->net->request($apiUrl, serialize($request), $hostIps);
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
