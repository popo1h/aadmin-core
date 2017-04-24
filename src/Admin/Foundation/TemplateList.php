<?php

namespace AadminCore\Admin\Foundation;

use AadminCore\Core\RequestParam;
use AadminCore\Foundation\Application;

class TemplateList
{
    /**
     * @param Application $application
     * @return array
     */
    public function getTemplateList(Application $application)
    {
        $result = [];

        $serverUrlMap = $application->config->getServerUrlMap();
        foreach ($serverUrlMap as $cateName => $serverUrl) {
            $response = $application->client->request($cateName, '__template_list', new RequestParam());
            $responseOutput = $response->output($application);
            $templateListJson = $responseOutput->getContent();

            $result[$cateName] = json_decode($templateListJson, true);
        }

        return $result;
    }
}
