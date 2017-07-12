<?php

namespace AadminCore\Admin\Foundation;

use AadminCore\Core\RequestParam;
use AadminCore\Foundation\Application;

class ActionList
{
    /**
     * @param Application $application
     * @param array|null $cateNames if null, get all actions
     * @return array
     */
    public function getActions(Application $application, $cateNames = null)
    {
        $result = [];

        $serverMap = $application->config->getServerMap();
        foreach ($serverMap as $cateName => $server) {
            if (isset($cateNames) && !in_array($cateName, $cateNames)) {
                continue;
            }

            $response = $application->client->request($cateName, '__action_list', new RequestParam());
            $responseOutput = $response->output($application);
            $actionListJson = $responseOutput->getContent();

            $result[$cateName] = json_decode($actionListJson, true);
        }

        return $result;
    }
}
