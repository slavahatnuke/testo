<?php


namespace Testo\XSource;


class XMethodSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getContent()
    {
        $source = new XMethodSource('Testo\Tests\x_files\Example', 'helloWorld');

        $this->assertSame('$helloWorld = new \HelloWorld;' . "\n\n" . '$helloWorld->say();' . "\n" , $source->getContent());

    }

    /**
     * @test
     * @expectedException \Testo\Exception\SourceNotFoundException
     * @expectedExceptionMessage Testo\Tests\x_files\Example::helloWorldFOOO
     */
    public function shouldThrowExceptionWhen()
    {
        $source = new XMethodSource('Testo\Tests\x_files\Example', 'helloWorldFOOO');

        $source->getContent();
    }

}
