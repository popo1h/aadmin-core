<?php

namespace AadminCore\AdminServer\Actions;

use AadminCore\Core\Action;
use AadminCore\Core\RequestParam;
use AadminCore\Core\Response\Json;

class TemplateList extends Action
{
    /**
     * @var string
     */
    private $templatePath;

    /**
     * @param string $templatePath
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    public static function getName()
    {
        return '__template_list';
    }

    public static function getIntro()
    {
        return 'get all templates';
    }

    private function getFiles($path, $basePath = '')
    {
        if (!is_dir($path)) {
            return [];
        }

        $files = [];

        $handle = dir($path);
        while (true) {
            $filename = $handle->read();
            if (!$filename) {
                break;
            } elseif ($filename == '.' || $filename == '..') {
                continue;
            }

            $fullFilename = $path . DIRECTORY_SEPARATOR . $filename;
            if (is_dir($fullFilename)) {
                $files = array_merge($files, $this->getFiles($fullFilename, $filename . DIRECTORY_SEPARATOR));
            } else {
                $files[$basePath . $filename] = $fullFilename;
            }
        }

        return $files;
    }

    private function getTemplateList()
    {
        $templateFiles = $this->getFiles($this->templatePath);

        $templateList = [];
        foreach ($templateFiles as $templateName => $templateFileName) {
            $templateList[$templateName] = [
                'content' => file_get_contents($templateFileName),
            ];
        }

        return $templateList;
    }

    public function doAction(RequestParam $param)
    {
        $response = new Json();

        $response->setData($this->getTemplateList());

        return $response;
    }
}
