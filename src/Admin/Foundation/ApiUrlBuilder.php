<?php

namespace AadminCore\Admin\Foundation;

/**
 * Url Builder for admin api
 */
class ApiUrlBuilder
{
    public static function getApiUrl($apiBaseUrl, $cateName, $actionName, $param = [])
    {
        if (!isset($cateName)) {
            $cateName = '__local__';
        }

        if (strpos($apiBaseUrl, '?') !== false) {
            $apiUrl = $apiBaseUrl . '&';
        } else {
            $apiUrl = $apiBaseUrl . '?';
        }

        return $apiUrl . http_build_query(array_merge($param, [
                '__aadmin_cate_name' => $cateName,
                '__aadmin_action_name' => $actionName,
            ]));
    }
}
