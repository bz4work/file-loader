<?php

class CurlLoaderTest extends \Codeception\Test\Unit
{
    /** @var \UnitTester */
    protected $tester;

    /** @var \bz4work\fileloader\CurlLoader $loader */
    protected $loader;
    
    protected function _before()
    {
        $this->loader = Yii::$container->get('bz4work\fileloader\CurlLoader');
    }

    protected function _after()
    {
        $this->loader = null;
    }

    public function testCreateObj()
    {
        $loader = Yii::$container->get('bz4work\fileloader\CurlLoader');

        $this->assertNotEmpty($loader);
        $this->assertEquals('bz4work\fileloader\CurlLoader', get_class($loader));
    }

    public function testLoad()
    {
        $url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
        $this->loader->load($url);

        $this->assertObjectHasAttribute('response_headers', $this->loader);
        $this->assertObjectHasAttribute('response_body', $this->loader);

        $this->assertNotEmpty($this->loader->getResponseHeaders());
        $this->assertIsArray($this->loader->getResponseHeaders());

        $this->assertNotEmpty($this->loader->getResponseBody());

        $this->assertNotEmpty($this->loader->getHeader('Content-Length'));
        $this->assertNotEmpty($this->loader->getHeader('Content-Type'));
        $this->assertNotEmpty($this->loader->getHeader('Status'));

        $this->assertEmpty($this->loader->getHeader(''));
        $this->assertEmpty($this->loader->getHeader('abracadabra'));
    }

    public function testLoadWithWtongParam()
    {
        $this->expectException(\Exception::class);

        $url = 'abracadabra';
        $this->loader->load($url);
    }
}