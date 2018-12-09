<?php
namespace bz4work\fileloader;

/**
 * Interface ComponentInterface
 * @package bz4work\fileloader
 */
interface ComponentInterface
{
    public function loadAndSave(string $url);
}