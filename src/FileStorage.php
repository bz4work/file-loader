<?php

namespace bz4work\fileloader;

/**
 * Class FileStorage
 * @package bz4work\fileloader
 */
class FileStorage implements StorageInterface
{
    /** @var $save_path - full path for save file */
    public $save_path;

    /** @var ConfigInterface $config */
    private $config;

    /** @var string $ds */
    private $ds = DIRECTORY_SEPARATOR;

    /** @var $print_path - path for print file in html tag */
    private $print_path;

    /** @var $new_file_name - unique generated filename with extension*/
    private $new_file_name;

    /**
     * FileStorage constructor.
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;

        $this->init();
    }

    /**
     * Creates and saves the file at the specified path.
     *
     * @param FileInterface $file
     * @return bool|string
     * @throws \Exception
     */
    public function save(FileInterface $file)
    {
        $filename = $this->getSavePath($file);

        if (empty($filename)) {
            throw new \Exception('Filename cannot be empty.');
        }

        if (empty(pathinfo($filename)['extension'])) {
            throw new \Exception('Filename must contain an extension.');
        }

        if (!is_writable(dirname($this->save_path))) {
            throw new \Exception('Destination folder not allowed to writable: ('.dirname($this->save_path).'). Please check permissions. Or read README file.');
        }

        if ($file->create($filename)) {//file created successful
            return $this->print_path.$this->new_file_name;
        } else {//file is not created
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getPrintPath()
    {
        return $this->print_path;
    }

    /**
     * Generates the full path where the file will be saved.
     *
     * @param FileInterface $file
     * @return string
     */
    private function getSavePath($file)
    {
        $uniq_name = uniqid() . '.' . $file->getType();
        $this->new_file_name = $uniq_name;//save name for next action: output in browser

        $this->save_path .= $uniq_name;

        return $this->save_path;
    }

    /**
     * Initialize some vars after create object.
     */
    private function init()
    {
        $this->print_path = $this->config->get('path').$this->ds;
        $this->save_path = \Yii::getAlias('@app')
            .$this->config->get('path_main').$this->ds
            .$this->config->get('path').$this->ds;
    }
}