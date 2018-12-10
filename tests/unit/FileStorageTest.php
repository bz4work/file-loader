<?php

class FileStorageTest extends \Codeception\Test\Unit
{
    /** @var \UnitTester */
    protected $tester;

    /** @var \bz4work\fileloader\FileStorage $storage */
    protected $storage;

    /** @var \bz4work\fileloader\ImagesFile $file */
    protected $file;
    
    protected function _before()
    {
        $this->storage = Yii::$container->get('bz4work\fileloader\FileStorage');
        $this->file = Yii::$container->get('bz4work\fileloader\ImagesFile');
    }

    protected function _after()
    {
        $this->storage = null;
    }

    public function testCreateObj()
    {
        $this->assertNotEmpty($this->storage);
        $this->assertEquals('bz4work\fileloader\FileStorage', get_class($this->storage));
    }

    public function testSaveFile()
    {
        $url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
        $raw_data = file_get_contents($url);

        $file_resource = $this->file->initResourceFile($raw_data, 'image/jpeg');
        $path = $this->storage->save($file_resource);

        $full_file_path = dirname(__DIR__).DIRECTORY_SEPARATOR.'_data'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.$path;

        $this->assertFileExists($full_file_path);
        $this->assertFileIsReadable($full_file_path);
    }

    public function testGetters()
    {
        $this->assertNotEmpty($this->storage->getPrintPath());
    }

}