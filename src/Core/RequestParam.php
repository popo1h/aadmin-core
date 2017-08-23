<?php

namespace AadminCore\Core;

use AadminCore\Core\RequestParam\File;

class RequestParam implements \Serializable
{
    /**
     * @var array
     */
    private $post = [];

    /**
     * @var array
     */
    private $get = [];

    /**
     * @var File[]
     */
    private $file = [];

    /**
     * @return array
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param array $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return array
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @param array $get
     */
    public function setGet($get)
    {
        $this->get = $get;
    }

    /**
     * @return array
     */
    public function getFile()
    {
        $result = [];
        foreach ($this->file as $key => $file) {
            $result[$key] = $file->toFile();
        }
        return $result;
    }

    /**
     * @param array $files
     */
    public function setFileByFiles($files)
    {
        $this->file = [];
        foreach ($files as $key => $file) {
            $fileObj = File::buildByFile($file);
            if ($fileObj) {
                $this->file[$key] = $fileObj;
            }
        }
    }

    /**
     * @param string $name
     * @param mixed $default
     * @param callable $dealFunction
     * @return mixed
     */
    public function getPostDataByName($name, $default = null, $dealFunction = null)
    {
        if (!isset($this->post[$name])) {
            return $default;
        }

        $postData = $this->post[$name];
        if (isset($dealFunction)) {
            $postData = $dealFunction($postData);
        }

        return $postData;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @param callable $dealFunction
     * @return mixed
     */
    public function getGetDataByName($name, $default = null, $dealFunction = null)
    {
        if (!isset($this->get[$name])) {
            return $default;
        }

        $getData = $this->get[$name];
        if (isset($dealFunction)) {
            $getData = $dealFunction($getData);
        }

        return $getData;
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function getFileDataByName($name)
    {
        if (!isset($this->file[$name])) {
            return [];
        }

        return $this->file[$name]->toFile();
    }

    /**
     * @param string $name
     * @param mixed $default
     * @param callable $dealFunction
     * @return mixed
     */
    public function getDataByName($name, $default = null, $dealFunction = null)
    {
        $result = $this->getPostDataByName($name, null, $dealFunction);

        if (!isset($result)) {
            $result = $this->getGetDataByName($name, null, $dealFunction);
        }

        if (!isset($result)) {
            $result = $default;
        }

        return $result;
    }

    protected function getSerializeValMap()
    {
        return [
            'post',
            'get',
            'file',
        ];
    }

    public function serialize()
    {
        $arr = [];
        foreach ($this->getSerializeValMap() as $item) {
            $arr[$item] = $this->$item;
        }

        return serialize($arr);
    }

    public function unserialize($serialized)
    {
        $arr = unserialize($serialized);

        foreach ($this->getSerializeValMap() as $item) {
            $this->$item = $arr[$item];
        }
    }
}
