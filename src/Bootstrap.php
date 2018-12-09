<?php
namespace bz4work\fileloader;


use yii\base\BootstrapInterface;
use yii\di\Instance;

class Bootstrap implements BootstrapInterface
{
    private $container_alias = 'FileLoaderComponent';

    public function bootstrap($app)
    {
        $container = \Yii::$container;

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