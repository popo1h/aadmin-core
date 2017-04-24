<?php

namespace AadminCore\Foundation\ApplicationContainerProvider;

use AadminCore\Api\ApiServer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['server'] = function ($pimple) {
            return new ApiServer($pimple['config']->getNet());
        };
    }
}
