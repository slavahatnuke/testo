<?php

namespace Testo\XDocument;


class XDocumentTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function construct()
    {

        $source = $this->getMock('\Testo\XSource\XSourceInterface');
        $document = new XDocument($source);

        $this->assertSame($source, $document->getSource());
    }

    /**
     * @test
     */
    public function toString()
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
