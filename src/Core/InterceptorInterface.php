<?php

namespace AadminCore\Core;

interface InterceptorInterface
{
    /**
     * @param $params
     * @return mixed|null if not null, it will intercept
     */
    public function intercept(&$params);
}
