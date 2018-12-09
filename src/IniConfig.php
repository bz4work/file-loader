<?php

namespace bz4work\fileloader;


class IniConfig implements ConfigInterface
{
    private $configs;

    public function __construct()
    {
        $ds = DIRECTORY_SEPARATOR;
        $path = __DIR__.$ds.'config'.$ds.'config.ini';
        $this->load($path);
    }

    public function getAll()
    {
        return $this->configs;
    }

    public function get($name)
    {
        if(empty($this->configs) && !is_array($this->configs)){
           return false;
        }

        return isset($this->configs[$name]) ? $this->configs[$name] : false;
    }

    public function load($path)
    {
        $this->configs = parse_ini_file($path);
    }

    public function set($name, $value)
    {
        if(empty($name) || empty($value)){
            return false;
        }

        $this->configs[$name] = $value;

        return $this->configs[$name];
    }
}