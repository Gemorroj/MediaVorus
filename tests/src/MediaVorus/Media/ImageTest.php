<?php

namespace MediaVorus\Media;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Image
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new Image(new \SplFileInfo(__DIR__ . '/../../../files/ExifTool.jpg'));
    }

    /**
     * @covers \MediaVorus\Media\Image::getWidth
     */
    public function testGetWidth()
    {
        $this->assertTrue(is_int($this->object->getWidth()));
        $this->assertEquals(8, $this->object->getWidth());
    }

    /**
     * @covers \MediaVorus\Media\Image::getHeight
     */
    public function testGetHeight()
    {
        $this->assertTrue(is_int($this->object->getHeight()));
        $this->assertEquals(8, $this->object->getHeight());
    }

    /**
     * @covers \MediaVorus\Media\Image::getChannels
     */
    public function testGetChannels()
    {
        $this->assertTrue(is_int($this->object->getChannels()));
        $this->assertEquals(3, $this->object->getChannels());
    }

    /**
     * @covers \MediaVorus\Media\Image::getFocalLength
     */
    public function testGetFocalLength()
    {
        $this->assertTrue(is_float($this->object->getFocalLength()));
        $this->assertEquals(6.0, $this->object->getFocalLength());
    }

    /**
     * @covers \MediaVorus\Media\Image::getColorDepth
     */
    public function testGetColorDepth()
    {
        $this->assertTrue(is_int($this->object->getColorDepth()));
        $this->assertEquals(8, $this->object->getColorDepth());
    }

    /**
     * @covers \MediaVorus\Media\Image::getCameraModel
     */
    public function testGetCameraModel()
    {
        $this->assertTrue(is_string($this->object->getCameraModel()));
    }

    /**
     * @covers \MediaVorus\Media\Image::getFlashFired
     */
    public function testGetFlashFired()
    {
        $this->assertTrue(is_bool($this->object->getFlashFired()));
    }

    /**
     * @covers \MediaVorus\Media\Image::getAperture
     */
    public function testGetAperture()
    {
        $this->assertInternalType('float', $this->object->getAperture());
    }

    /**
     * @covers \MediaVorus\Media\Image::getShutterSpeed
     */
    public function testGetShutterSpeed()
    {
        $this->assertInternalType('float', $this->object->getShutterSpeed());
    }

    /**
     * @covers \MediaVorus\Media\Image::getOrientation
     */
    public function testGetOrientation()
    {
        $this->assertTrue(is_int($this->object->getOrientation()));
    }

    /**
     * @covers \MediaVorus\Media\Image::getCreationDate
     */
    public function testGetCreationDate()
    {
        $this->assertTrue(is_string($this->object->getCreationDate()));
    }

    /**
     * @covers \MediaVorus\Media\Image::getHyperfocalDistance
     */
    public function testGetHyperfocalDistance()
    {
        $this->assertInternalType('float', $this->object->getHyperfocalDistance());
    }

    /**
     * @covers \MediaVorus\Media\Image::getISO
     */
    public function testGetISO()
    {
        $this->assertTrue(is_int($this->object->getISO()));
        $this->assertEquals(100, $this->object->getISO());
    }

    /**
     * @covers \MediaVorus\Media\Image::getLightValue
     */
    public function testGetLightValue()
    {
        $this->assertInternalType('float', $this->object->getLightValue());
    }

    /**
     * @covers \MediaVorus\Media\Image::getColorSpace
     */
    public function testGetColorSpace()
    {
        $media = new \MediaVorus\Media\Image(__DIR__ . '/../../../files/ExifTool.jpg');

        $this->assertEquals(\MediaVorus\Media\Image::COLORSPACE_RGB, $media->getColorSpace());
    }
}
