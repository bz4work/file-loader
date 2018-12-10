<?php

namespace bz4work\fileloader;

/**
 * Interface ComponentInterface
 * @package bz4work\fileloader
 */
interface ComponentInterface
{
    /**
     * @param string $url
     * @return mixed
     */
    public function loadAndSave(string $url);
}