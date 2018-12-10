<?php

namespace bz4work\fileloader;

/**
 * Class ImagesFile
 * @package bz4work\fileloader
 */
class ImagesFile implements FileInterface
{
    /** @var array $allowTypes */
    private $allowTypes;

    /** @var ConfigInterface $config */
    private $config;

    /** @var string $type */
    private $type;

    /** @var resource $resource */
    private $resource;

    /**
     * ImagesFile constructor.
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;

        $this->init();
    }

    /**
     * Create a resource to the new file.
     *
     * @param $raw_file_data
     * @param string $image_type
     * @return $this
     * @throws \Exception
     */
    public function initResourceFile($raw_file_data, string $image_type)
    {
        $this->setType($image_type);

        $this->resource = imagecreatefromstring($raw_file_data);
        return $this;
    }

    /**
     * Creates a file in the specified path.
     *
     * @param $path - full path for create file
     * @return bool
     */
    public function create($path)
    {
        $success = false;

        switch ($this->type) {
            case 'jpg':
            case 'jpeg':
                $success = imagejpeg($this->resource, $path, $this->config->get('jpg_quality'));
                break;
            case 'gif':
                $success = imagegif($this->resource, $path);
                break;
            case 'png':
                $success = imagepng($this->resource, $path, $this->config->get('png_compression'));
                break;
        }

        return $success;
    }

    /**
     * Set file type.
     *
     * @param $type - string like 'image/jpg'
     * @throws \Exception
     */
    private function setType($type)
    {
        list($mime, $extension) = explode('/', $type);

        if (in_array($extension, $this->allowTypes)) {
            $this->type = $extension;
        } else {
            throw new \Exception('Extension not supported.');
        }
    }

    /**
     * Return file type.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Initialize some vars after create object.
     */
    private function init()
    {
        //create array from config string
        $this->allowTypes = explode(',', $this->config->get('allow_types'));
    }
}