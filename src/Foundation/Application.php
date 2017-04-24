<?php

namespace AadminCore\Foundation;

use AadminCore\Foundation\ApplicationContainerProvider\AdminApiProvider;
use AadminCore\Foundation\ApplicationContainerProvider\AdminIndexProvider;
use AadminCore\Foundation\ApplicationContainerProvider\ClientProvider;
use AadminCore\Foundation\ApplicationContainerProvider\ServerProvider;
use AadminCore\Foundation\ApplicationContainerProvider\TemplateProvider;
use Pimple\Container;

/**
 * Class Application
 *
 * @property \AadminCore\Api\ApiServer $server
 * @property \AadminCore\Api\ApiClient $client
 * @property \Twig_Environment $template
 * @property \AadminCore\View\TemplateLoader $templateLoader
 * @property \AadminCore\View\TemplateBaseData $templateBaseData
 * @property Config $config
 * @property \AadminCore\Admin\Api $adminApi
 */
class Application
{
    protected $container;

    protected $containerProviders = [
        ServerProvider::class,
        ClientProvider::class,
        TemplateProvider::class,
        AdminApiProvider::class,
    ];

    protected $containerMap = [
        'config' => 'config',
        'server' => 'server',
        'client' => 'client',
        'template' => 'template',
        'templateLoader' => 'template_loader',
        'templateBaseData' => 'template_base_data',
        'adminApi' => 'admin_api',
    ];

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->container = new Container([
            'config' => $config,
        ]);

        $this->containerRegisterBase();
        $this->containerRegisterProviders();
    }

    public function __get($name)
    {
        if (isset($this->containerMap[$name])) {
            return $this->container[$this->containerMap[$name]];
        }

        return null;
    }

    protected function containerRegisterBase()
    {
    }

    protected function containerRegisterProviders()
    {
        foreach ($this->containerProviders as $containerProvider) {
            $this->container->register(new $containerProvider());
        }
    }
}
