<?php


namespace Testo\XSource;


class XStringSourceTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function getContent()
    {
        $content = 'xxx';
        $source = new XStringSource($content);

        $this->assertSame($content, $source->getContent());
        $this->assertSame($content, $source->getName());
    }

    /**
     * @test
     */
    public function constructWithoutArguments()
    {
        $source = new XStringSource();

        $this->assertSame('', $source->getContent());
    }
}
