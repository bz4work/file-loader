<?php

namespace bz4work\fileloader;

use yii\base\BootstrapInterface;
use yii\di\Instance;

/**
 * Class Bootstrap
 * @package bz4work\fileloader
 */
class Bootstrap implements BootstrapInterface
{
    /** @var string $container_alias */
    private $container_alias = 'FileLoaderComponent';

    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;//get DI container

        $container->setSingletons([
            'bz4work\fileloader\IniConfig' => [
                ['class' => 'bz4work\fileloader\IniConfig']
            ],
            'bz4work\fileloader\FileStorage' => [
                ['class' => 'bz4work\fileloader\FileStorage'],
                [//constructor params:
                    Instance::of('bz4work\fileloader\IniConfig'),
                ]
            ]
        ]);

        $container->setDefinitions([
            'bz4work\fileloader\CurlLoader' => [
                ['class' => 'bz4work\fileloader\CurlLoader']
            ],
            'bz4work\fileloader\ImagesFile' => [
                ['class' => 'bz4work\fileloader\ImagesFile'],
                [//constructor params:
                    Instance::of('bz4work\fileloader\IniConfig'),
                ]
            ],
            $this->container_alias => [
                ['class' => 'bz4work\fileloader\FileLoaderComponent'],
                [//constructor params:
                    Instance::of('bz4work\fileloader\CurlLoader'),
                    Instance::of('bz4work\fileloader\FileStorage'),
                    Instance::of('bz4work\fileloader\ImagesFile'),
                ]
            ]
        ]);
    }
}