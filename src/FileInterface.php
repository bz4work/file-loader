<?php

namespace bz4work\fileloader;

/**
 * Interface FileInterface
 * @package bz4work\fileloader
 */
interface FileInterface
{
    /**
     * Create Resource for file to a given type.
     *
     * @param $raw_file_data
     * @param string $file_type
     * @return mixed
     */
    public function initResourceFile($raw_file_data, string $file_type);

    /**
     * Create a file at the specified path.
     *
     * @param $path
     * @return mixed
     */
    public function create($path);
}