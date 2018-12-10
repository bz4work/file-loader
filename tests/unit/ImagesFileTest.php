<?php

class ImagesFileTest extends \Codeception\Test\Unit
{
    /** @var \UnitTester */
    protected $tester;

    /** @var \bz4work\fileloader\ImagesFile $file */
    protected $file;

    protected function _before()
    {
        $this->file = Yii::$container->get('bz4work\fileloader\ImagesFile');
    }

    protected function _after()
    {
        $this->file = null;
    }

    public function testInitResource()
    {
        $url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
        $raw_data = file_get_contents($url);

        $this->file->initResourceFile($raw_data, 'image/jpeg');

        $this->assertNotEmpty($this->file->getResource());
        $this->assertIsResource($this->file->getResource());
    }

    public function testInitResourceWrongDataParam()
    {
        $this->expectExceptionMessageRegExp('|Empty string or invalid image|');
        $this->file->initResourceFile('', 'image/jpeg');
        $this->file->initResourceFile('abracadabra', 'image/jpeg');
        $this->file->initResourceFile(null, 'image/jpeg');
    }

    public function testInitResourceNoAllowedExtensionTypeParam()
    {
        $url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
        $raw_data = file_get_contents($url);

        $this->expectException(\Exception::class);
        $this->file->initResourceFile($raw_data, 'image/mp4');
    }

    public function testInitResourceWrongTypeParam()
    {
        $url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
        $raw_data = file_get_contents($url);

        $this->expectException(\Exception::class);

        $this->file->initResourceFile($raw_data, 'image');
        $this->file->initResourceFile($raw_data, 'gif');
        $this->file->initResourceFile($raw_data, '');
    }

    public function testCreateJPEGFile()
    {
        $url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
        $raw_data = file_get_contents($url);

        $full_file_path = dirname(__DIR__) . DIRECTORY_SEPARATOR
            . '_data' . DIRECTORY_SEPARATOR
            .  'web' . DIRECTORY_SEPARATOR
            . 'loaded_images' . DIRECTORY_SEPARATOR
            . time() . '.jpeg';

        $this->file->initResourceFile($raw_data, 'image/jpeg');
        $result = $this->file->create($full_file_path);

        $this->assertTrue($result);
        $this->assertFileExists($full_file_path);
        $this->assertFileIsReadable($full_file_path);
    }

    public function testCreatePNGFiles()
    {
        $url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
        $raw_data = file_get_contents($url);

        $full_file_path = dirname(__DIR__) . DIRECTORY_SEPARATOR
            . '_data' . DIRECTORY_SEPARATOR
            .  'web' . DIRECTORY_SEPARATOR
            . 'loaded_images' . DIRECTORY_SEPARATOR
            . time() . '.png';

        $this->file->initResourceFile($raw_data, 'image/png');
        $result = $this->file->create($full_file_path);

        $this->assertTrue($result);
        $this->assertFileExists($full_file_path);
        $this->assertFileIsReadable($full_file_path);
    }

    public function testCreateGIFFile()
    {
        $url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
        $raw_data = file_get_contents($url);

        $full_file_path = dirname(__DIR__) . DIRECTORY_SEPARATOR
            . '_data' . DIRECTORY_SEPARATOR
            .  'web' . DIRECTORY_SEPARATOR
            . 'loaded_images' . DIRECTORY_SEPARATOR
            . time() . '.gif';

        $this->file->initResourceFile($raw_data, 'image/gif');
        $result = $this->file->create($full_file_path);

        $this->assertTrue($result);
        $this->assertFileExists($full_file_path);
        $this->assertFileIsReadable($full_file_path);
    }
}