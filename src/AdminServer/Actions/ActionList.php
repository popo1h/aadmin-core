<?php

namespace AadminCore\AdminServer\Actions;

use AadminCore\Core\Action;
use AadminCore\Core\RequestParam;
use AadminCore\Core\Response\Json;

class ActionList extends Action
{
    /**
     * @var Action[]
     */
    protected $actions;

    /**
     * @param Action[] $actions
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
    }

    public static function getName()
    {
        return '__action_list';
    }

    public static function getIntro()
    {
        return 'get all actions';
    }

    public function doAction(RequestParam $param)
    {
        $list = [];

        foreach ($this->actions as $action) {
            $group = $action::getGroup();
            if (isset($group)) {
                $groupInfo = [
                    'name' => $group::getName(),
                    'intro' => $group::getIntro(),
                ];
            } else {
                $groupInfo = null;
            }

            $list[] = [
                'name' => $action::getName(),
                'intro' => $action::getIntro(),
                'group' => $groupInfo,
            ];
        }

        $response = new Json();
        $response->setData($list);

        return $response;
    }
}
