<?php

namespace AadminCore\Admin\Crontab;

use AadminCore\Admin\Foundation\TemplateList;
use AadminCore\Foundation\Application;

class TemplateSync
{
    private function writeFile($fileName, $fileContent)
    {
        $dirPath = dirname($fileName);

        if (!is_dir($dirPath)) {
            $res = mkdir($dirPath, 0775, true);
        }

        file_put_contents($fileName, $fileContent);
    }

    /**
     * @param Application $application
     */
    public function run(Application $application)
    {
        $ds = DIRECTORY_SEPARATOR;

        $templateListApi = new TemplateList();
        $templateAllList = $templateListApi->getTemplateList($application);

        $templateCachePath = $application->config->getCachePath() . $ds . 'template' . $ds;
        foreach ($templateAllList as $cateName => $templateList) {
            $templateCateCachePath = $templateCachePath . $cateName . $ds;
            foreach ($templateList as $templateName => $template) {
                $fileName = $templateCateCachePath . $templateName;
                $this->writeFile($fileName, $template['content']);
            }
        }
    }
}
