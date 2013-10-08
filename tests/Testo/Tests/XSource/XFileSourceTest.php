<?php
namespace Testo\Tests\XSource;
use Testo\XSource\XFileSource;

class XFileSourceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getContent()
    {
        $path = __DIR__ . '/Fixtures/file_source.txt';
        $source = new XFileSource($path);

        $this->assertEquals(file_get_contents($path), $source->getContent());
    }

    /**
     * @test
     * @expectedException \Testo\Exception\SourceNotFoundException
     * @expectedExceptionMessage file_source.txt_FOO
     */
    public function shouldThrowExceptionWhenFileIsNotExists()
    {

        $path = __DIR__ . '/Fixtures/file_source.txt_FOO';
        $source = new XFileSource($path);
        $source->getContent();
    }

    /**
     * @test
     */
    public function getName()
    {
        $path = __DIR__ . '/Fixtures/file_source.txt';
        $source = new XFileSource($path);

        $this->assertEquals($path, $source->getName());
    }

}
