<?php

namespace AadminCore\Core;

abstract class Action
{
    /**
     * @return string
     */
    public static function getName()
    {
        return static::class;
    }

    /**
     * The introduction of what the action do
     * @return string
     */
    public static function getIntro()
    {
        return '';
    }

    /**
     * @return null|ActionGroup
     */
    public static function getGroup()
    {
        return null;
    }

    /**
     * @param RequestParam $param
     * @return Response
     */
    abstract public function doAction(RequestParam $param);
}
