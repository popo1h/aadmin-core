<?php

namespace AadminCore\Core;

abstract class ActionGroup
{
    /**
     * @return string
     */
    public static function getName()
    {
        return static::class;
    }

    /**
     * The introduction of what the action group do
     * @return string
     */
    public static function getIntro()
    {
        return '';
    }
}
