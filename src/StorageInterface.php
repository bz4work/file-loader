<?php
namespace bz4work\fileloader;

/**
 * Interface StorageInterface
 * @package bz4work\fileloader
 */
interface StorageInterface
{
    /**
     * Save file into storage.
     *
     * @param FileInterface $file_object
     * @return mixed
     */
    public function save(FileInterface $file_object);
}