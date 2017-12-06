<?php

namespace AadminCore\Core;

class ActionSubAuthentication
{
    /**
     * @var string
     */
    private $authName;

    /**
     * @var string
     */
    private $intro;

    /**
     * @param string $authName
     * @param string $intro
     */
    public function __construct($authName, $intro)
    {
        $this->authName = $authName;
        $this->intro = $intro;
    }

    /**
     * @return string
     */
    public function getAuthName()
    {
        return $this->authName;
    }

    /**
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }
}
