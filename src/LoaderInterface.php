<?php
namespace bz4work\fileloader;

/**
 * Interface LoaderInterface
 * @package bz4work\fileloader
 */
interface LoaderInterface
{
    /**
     * Load file from source.
     *
     * @param $url
     * @return mixed
     */
    public function load($url);
}