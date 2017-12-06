<?php

namespace AadminCore\Core;

abstract class Action
{
    /**
     * @var string
     */
    protected $userId;

    /**
     * @return string
     */
    public static function getName()
    {
        return static::class;
    }

    /**
     * @return null
     */
    public static function getGroup()
    {
        return null;
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
     * The sub permission this action need use
     * @return ActionSubAuthentication[]
     */
    public static function getSubAuthName()
    {
        return [];
    }

    /**
     * Check whether now user has the permission named $authName
     * @param string $authName
     * @param bool $isSubAuth
     * @return bool
     */
    public function checkAuth($authName, $isSubAuth = true)
    {
        return true;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param RequestParam $param
     * @return Response
     */
    abstract public function doAction(RequestParam $param);
}
