<?php

class IniConfigTest extends \Codeception\Test\Unit
{
    /** @var \UnitTester */
    protected $tester;

    /** @var \bz4work\fileloader\IniConfig $config */
    protected $config;

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    protected function _before()
    {
        $this->config = Yii::$container->get('bz4work\fileloader\IniConfig');//get container which register in Bootstrap class
    }

    protected function _after()
    {
        $this->config = null;
    }

    public function testGetParam()
    {
        $param = $this->config->get('path');
        $this->assertNotEmpty($param);
        $this->assertIsString($param);
    }

    public function testGetParamWithWrongParam()
    {
        $param = $this->config->get('');
        $this->assertFalse($param);
    }

    public function testGetAll()
    {
        $all = $this->config->getAll();

        $this->assertNotEmpty($all);
        $this->assertIsArray($all);
    }

    public function testCreateObjWithEmptyPath()
    {
        $this->expectException(\Exception::class);
        new \bz4work\fileloader\IniConfig('');
    }

    public function testCreateObjWithWrongFilePath()
    {
        $this->expectException(\Exception::class);
        new \bz4work\fileloader\IniConfig('/Yahooo.php');
    }
}