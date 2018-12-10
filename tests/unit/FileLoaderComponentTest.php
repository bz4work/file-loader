<?php
class FileLoaderComponentTest extends \Codeception\Test\Unit
{
    /** @var \UnitTester */
    protected $tester;

    /** @var \bz4work\fileloader\FileLoaderComponent $component */
    protected $component;
    
    protected function _before()
    {
        $this->component = Yii::$container->get('FileLoaderComponent');
    }

    protected function _after()
    {
        $this->component = null;
    }

    public function testGetContainer()
    {
        $this->assertObjectHasAttribute('loader', $this->component);
        $this->assertObjectHasAttribute('storage', $this->component);
        $this->assertObjectHasAttribute('file', $this->component);

        $this->assertNotEmpty($this->component->loader);
        $this->assertNotEmpty($this->component->storage);
        $this->assertNotEmpty($this->component->file);
    }

    public function testLoadAndSaveFile()
    {
        $url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
        $path = $this->component->loadAndSave($url);

        $full_file_path = dirname(__DIR__).DIRECTORY_SEPARATOR.'_data'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.$path;

        $this->assertFileExists($full_file_path);
        $this->assertFileIsReadable($full_file_path);

        $full_file_path = null;
    }

    public function testConfigFileIsset()
    {
        $full_config_path = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR
            .'src'.DIRECTORY_SEPARATOR
            .'config'.DIRECTORY_SEPARATOR
            .'config.ini';

        $this->assertFileExists($full_config_path);
        $this->assertFileIsReadable($full_config_path);
    }

    public function testConfigFileFormat()
    {
        $full_config_path = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR
            .'src'.DIRECTORY_SEPARATOR
            .'config'.DIRECTORY_SEPARATOR
            .'config.ini';

        $this->assertEquals('ini', pathinfo($full_config_path)['extension']);
    }
}