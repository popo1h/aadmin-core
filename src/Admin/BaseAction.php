<?php

namespace AadminCore\Admin;

use AadminCore\Core\Action;
use AadminCore\Core\Response\Json;
use AadminCore\Core\Response\View;

abstract class BaseAction extends Action
{
    const CODE_SUCCESS = 1;
    const CODE_ERROR = 0;

    protected function buildViewPage($nowPage, $totalCount, $perPageCount, $pageParamName = 'page_id')
    {
        return [
            'now_page' => $nowPage,
            'total_count' => $totalCount,
            'per_page_count' => $perPageCount,
            'page_param_name' => $pageParamName,
            'now_action_name' => static::getName(),
        ];
    }

    protected function buildViewResponse($templateName, $templateData = [])
    {
        $response = new View();

        $templateData['_now_action'] = static::getName();
        $response->setTemplateName($templateName);
        $response->setTemplateData($templateData);

        return $response;
    }

    protected function buildAjaxJump($jumpActionName, $jumpCateName = null)
    {
        return [
            'cate_name' => $jumpCateName,
            'action_name' => $jumpActionName,
        ];
    }

    protected function buildAjaxResponse($code, $info, $data = null, $jump = null)
    {
        $response = new Json();

        $response->setData([
            'code' => $code,
            'info' => $info,
            'data' => $data,
            'jump' => $jump,
        ]);

        return $response;
    }
}
