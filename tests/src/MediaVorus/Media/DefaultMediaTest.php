<?php

namespace MediaVorus\Media;

use MediaVorus\File;
use PHPExiftool\Reader;
use PHPExiftool\Writer;

class DefaultMediaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DefaultMedia
     */
    protected $object;
    protected $GPSobject;

    protected function setUp()
    {
        $reader = Reader::create();
        $writer = Writer::create();

        $file = __DIR__ . '/../../../files/ExifTool.jpg';
        $this->object = new DefaultMedia(new File($file), $reader->reset()->files($file)->first(), $writer);

        $file = __DIR__ . '/../../../files/GPS.jpg';
        $this->GPSobject = new DefaultMedia(new File($file), $reader->reset()->files($file)->first(), $writer);
    }

    public function testGetHash()
    {
        $this->assertEquals('47684e05475e7591e15140449b12bd6e3e1c82c44a89f1803410e82051a2c88e', $this->object->getHash('sha256'));
    }

    /**
     * @covers \MediaVorus\Media\DefaultMedia::getFile
     */
    public function testGetFile()
    {
        $this->assertInstanceOf('\MediaVorus\File', $this->object->getFile());
        $this->assertEquals('ExifTool.jpg', $this->object->getFile()->getFilename());
    }

    /**
     * @covers \MediaVorus\Media\DefaultMedia::getLongitude
     */
    public function testGetLongitude()
    {
        $this->assertInternalType('float', $this->GPSobject->getLongitude());
        $this->assertEquals(1.91416666666667, $this->GPSobject->getLongitude());
    }

    /**
     * @covers \MediaVorus\Media\DefaultMedia::getLongitudeRef
     */
    public function testGetLongitudeRef()
    {
        $this->assertTrue(in_array($this->GPSobject->getLongitudeRef(), array('W', 'E')));
    }

    /**
     * @covers \MediaVorus\Media\DefaultMedia::getLatitude
     */
    public function testGetLatitude()
    {
        $this->assertInternalType('float', $this->GPSobject->getLatitude());
        $this->assertEquals(54.9896666666667, $this->GPSobject->getLatitude());
    }

    /**
     * @covers \MediaVorus\Media\DefaultMedia::getLatitudeRef
     */
    public function testGetLatitudeRef()
    {
        $this->assertTrue(in_array($this->GPSobject->getLatitudeRef(), array('N', 'S')));
    }
}

