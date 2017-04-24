<?php

namespace AadminCore\Foundation\ApplicationContainerProvider;

use AadminCore\Api\ApiClient;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ClientProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['client'] = function ($pimple) {
            return new ApiClient($pimple['config']->getNet(), $pimple['config']->getServerUrlMap());
        };
    }
}
