<?php

namespace AadminCore\Foundation\ApplicationContainerProvider;

use AadminCore\Admin\Foundation\ApiUrlBuilder;
use AadminCore\View\TemplateBaseData;
use AadminCore\View\TemplateLoader;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class TemplateProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['template_loader'] = function ($pimple) {
            $loader = new TemplateLoader($pimple['config']->getCachePath() . DIRECTORY_SEPARATOR . 'template');

            $loader->addPath($pimple['config']->getBaseTemplatePath() . DIRECTORY_SEPARATOR . $pimple['config']->getBaseTemplateName(), '__base__');
            $loader->addPath($pimple['config']->getLocalTemplatePath(), '__local__');

            $serverUrlMap = $pimple['config']->getServerUrlMap();
            foreach ($serverUrlMap as $cateName => $serverUrl) {
                $loader->addPath($cateName, $cateName);
            }

            return $loader;
        };

        $pimple['template_base_data'] = $pimple['config']->getTemplateBaseData();

        $pimple['template'] = function ($pimple) {
            $twig = new \Twig_Environment($pimple['template_loader']);

            $staticBaseUrl = $pimple['config']->getStaticBaseUrl() . '/' . $pimple['config']->getBaseTemplateName();
            $twig->addFunction(new \Twig_Function('static_url', function () use ($staticBaseUrl) {
                return $staticBaseUrl;
            }));

            $temploader = $pimple['template_loader'];
            $apiBaseUrl = $pimple['config']->getClientServerBaseUrl();
            $twig->addFunction(new \Twig_Function('request_url', function ($cateName, $actionName, $param = []) use ($temploader, $apiBaseUrl) {
                if (!isset($cateName)) {
                    $cateName = $temploader->getMainNamespace();
                }

                return ApiUrlBuilder::getApiUrl($apiBaseUrl, $cateName, $actionName, $param);
            }));

            $twig->addFunction(new \Twig_Function('get_curent_cate_name', function () use ($temploader) {
                return $temploader->getMainNamespace();
            }));

            return $twig;
        };
    }
}
