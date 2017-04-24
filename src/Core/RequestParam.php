<?php

namespace AadminCore\Core;

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
     * @var array
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
        return $this->file;
    }

    /**
     * @param array $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @param callable $dealFunction
     * @return mixed
     */
    public function getPostDataByName($name, $default, $dealFunction = null)
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
    public function getGetDataByName($name, $default, $dealFunction = null)
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
