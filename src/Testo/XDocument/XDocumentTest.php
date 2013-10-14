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
        $this->assertNull($document->getSource());
    }

    /**
     * @test
     */
    public function constructWithoutArguments()
    {
        $document = new XDocument();
        $this->assertNull($document->getSource());
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

        // ignore empty documents
        $sub_document2 = new XDocument($source);
        $document->add($sub_document2);
        $this->assertSame("xxx\nxxx2", (string)$document);


    }

    /**
     * @test
     */
    public function getIterator()
    {
        $source = $this->getMock('\Testo\XSource\XSourceInterface');
        $document = new XDocument($source);

        $this->assertEquals(0, $document->getIterator()->count());

        $document->add('xxx');
        $this->assertEquals(1, $document->getIterator()->count());
    }

    /**
     * @test
     */
    public function isEmptyDocument()
    {
        $source = $this->getMock('\Testo\XSource\XSourceInterface');
        $document = new XDocument($source);

        $this->assertTrue($document->isEmpty());
        $document->add('xxx');
        $this->assertFalse($document->isEmpty());

    }
    

    
}
