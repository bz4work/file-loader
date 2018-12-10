<?php

namespace bz4work\fileloader;

use yii\base\Component;

/**
 * Class FileLoaderComponent
 * @package bz4work\fileloader
 */
class FileLoaderComponent extends Component implements ComponentInterface
{
    /** @var CurlLoader $loader */
    public $loader;

    /** @var FileStorage $repository */
    public $storage;

    /** @var ImagesFile $file */
    public $file;

    /**
     * FileLoaderComponent constructor.
     *
     * @param LoaderInterface $loader
     * @param StorageInterface $storage
     * @param FileInterface $file
     * @param array $config
     */
    public function __construct(
        LoaderInterface $loader,
        StorageInterface $storage,
        FileInterface $file,
        array $config = []
    )
    {
        $this->loader = $loader;
        $this->storage = $storage;
        $this->file = $file;

        parent::__construct($config);
    }

    /**
     * Load and save file from url.
     *
     * @param string $url
     * @return bool|string - false or path for saved file
     * @throws \Exception
     */
    public function loadAndSave(string $url)
    {
        $file_data = $this->loader->load($url);
        $type = $this->loader->getHeader('Content-Type');
        $file = $this->file->initResourceFile($file_data, $type);

        return $this->storage->save($file);
    }
}