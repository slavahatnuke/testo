<?php

namespace Testo\XDocument;


use Testo\XSource\XStringSource;

class XDocumentTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function construct()
    {

        $source = $this->getMock('\Testo\XSource\XSourceInterface');
        $document = new XDocument($source);

        $this->assertSame($source, $document->getSource());

        $document = new XDocument();
        $this->assertSame('', $document->getSource()->getContent());
    }

    /**
     * @test
     */
    public function constructWithoutArguments()
    {
        $document = new XDocument();
        $this->assertTrue($document->getSource() instanceof XStringSource);
        $this->assertSame('', $document->getSource()->getContent());
    }

    /**
     * @test
     */
    public function testToString()
    {
        $source = $this->getMock('\Testo\XSource\XSourceInterface');
        $document = new XDocument($source);
        
        $this->assertSame('', (string)$document);
    }

    /**
     * @test
     */
    public function addText()
    {
        $source = $this->getMock('\Testo\XSource\XSourceInterface');
        $document = new XDocument($source);
        $document->add('xxx');


        $this->assertSame('xxx', (string)$document);

        $document->add('yyy');

        $this->assertSame("xxx\nyyy", (string)$document);
    }

    /**
     * @test
     */
    public function addSubDocumentText()
    {
        $source = $this->getMock('\Testo\XSource\XSourceInterface');
        $document = new XDocument($source);
        $document->add('xxx');

        $source = $this->getMock('\Testo\XSource\XSourceInterface');
        
        $sub_document = new XDocument($source);
        $sub_document->add('xxx2');

        $document->add($sub_document);

        $this->assertSame("xxx\nxxx2", (string)$document);

    }
}
