<?php

namespace AadminCore\Foundation\ApplicationContainerProvider;

use AadminCore\Admin\Api;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AdminApiProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['admin_api'] = function ($pimple) {
            return new Api($pimple['client']);
        };
    }
}
