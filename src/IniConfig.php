<?php
namespace bz4work\fileloader;

/**
 * Class IniConfig
 * @package bz4work\fileloader
 */
class IniConfig implements ConfigInterface
{
    /** @var array $configs */
    private $configs;

    /**
     * IniConfig constructor.
     * @param string $config_path
     * @throws \Exception
     */
    public function __construct($config_path = '/config/config.ini')
    {
        $this->load($config_path);
    }

    /**
     * Returns all config params.
     *
     * @return array|mixed
     */
    public function getAll()
    {
        return $this->configs;
    }

    /**
     * Return param value at given param-name.
     *
     * @param string $name
     * @return bool|mixed
     */
    public function get($name)
    {
        if (empty($this->configs) && !is_array($this->configs)) {
           return false;
        }

        return isset($this->configs[$name]) ? $this->configs[$name] : false;
    }

    /**
     * Load and parse config file.
     *
     * @param string $path
     * @return $this|mixed
     * @throws \Exception
     */
    public function load($path)
    {
        if (empty($path)) {
            throw new \Exception('Config path is empty. Pass config file path in constructor.');
        }

        $path_parts = explode('/', $path);
        $clear_path = implode(DIRECTORY_SEPARATOR, $path_parts);
        $full_path = __DIR__ . $clear_path;

        if (!file_exists($full_path)) {
            throw new \Exception('Config file is not found. Check parameters or read README file.');
        }

        $this->configs = parse_ini_file($full_path);

        return $this;
    }
}