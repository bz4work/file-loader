<?php
namespace bz4work\fileloader;

/**
 * Interface ConfigInterface
 * @package bz4work\fileloader
 */
interface ConfigInterface
{
    /**
     * Get config param.
     *
     * @param string $name
     * @return mixed
     */
    public function get($name);

    /**
     * Set config param.
     *
     * @param string $name
     * @param $value
     * @return mixed
     */
    public function set($name, $value);

    /**
     * Get all params;
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Loading and parse config source file.
     *
     * @param $path
     * @return mixed
     */
    public function load($path);
}