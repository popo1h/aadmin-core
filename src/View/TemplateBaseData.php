<?php

namespace AadminCore\View;

class TemplateBaseData
{
    const DATA_TYPE_DATA = 0;
    const DATA_TYPE_CLOSURE = 1;

    private $datas = [];

    /**
     * @param string $dataName
     * @param mixed $content
     */
    public function setData($dataName, $content)
    {
        $this->datas[$dataName] = [
            'type' => self::DATA_TYPE_DATA,
            'content' => $content,
        ];
    }

    /**
     * @param string $dataName
     * @param \Closure $funcGetDataContent
     */
    public function registerDataGetter($dataName, $funcGetDataContent)
    {
        $this->datas[$dataName] = [
            'type' => self::DATA_TYPE_CLOSURE,
            'content' => $funcGetDataContent,
        ];
    }

    /**
     * @param \AadminCore\Core\RequestInfo $requestInfo
     * @return array
     */
    public function toArray($requestInfo)
    {
        $arr = [];

        foreach ($this->datas as $dataName => $data) {
            if ($data['type'] == self::DATA_TYPE_CLOSURE) {
                $arr[$dataName] = $data['content']($requestInfo);
            } else {
                $arr[$dataName] = $data['content'];
            }
        }

        return $arr;
    }
}
