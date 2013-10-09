<?php


namespace Testo\XDocument;


class XTagDocumentTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function construct()
    {
        $tag = $this->getMock('Testo\Tag\TagInterface');

        $document = new XTagDocument($tag);
        $this->assertSame($tag, $document->getTag());
        $this->assertTrue($document instanceof XDocument);
    }

    /**
     * @test
     */
    public function constructWithArguments()
    {
        $tag = $this->getMock('Testo\Tag\TagInterface');
        $source = $this->getMock('Testo\XSource\XSourceInterface');
        $end_tag = $this->getMock('Testo\Tag\TagInterface');

        $document = new XTagDocument($tag, $source, $end_tag);

        $this->assertSame($tag, $document->getTag());
        $this->assertSame($end_tag, $document->getEndTag());
        $this->assertSame($source, $document->getSource());
    }

    /**
     * @test
     */
    public function tagSetters()
    {
        $tag = $this->getMock('Testo\Tag\TagInterface');
        $end_tag = $this->getMock('Testo\Tag\TagInterface');

        $document = new XTagDocument($tag);

        $document->setTag($tag);
        $document->setEndTag($end_tag);

        $this->assertSame($tag, $document->getTag());
        $this->assertSame($end_tag, $document->getEndTag());
    }

    /**
     * @test
     */
    public function testToStringWithStartAndEndTags()
    {
        $tag = $this->getMock('Testo\Tag\TagInterface');
        $end_tag = $this->getMock('Testo\Tag\TagInterface');

        $document = new XTagDocument($tag, null, $end_tag);
        $document->add('MY-LINE');

        $tag->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('tag1'));

        $end_tag->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('tag2'));

        $this->assertSame("tag1\nMY-LINE\ntag2", (string)$document);
    }

    /**
     * @test
     */
    public function testToStringWithStartTag()
    {
        $tag = $this->getMock('Testo\Tag\TagInterface');

        $document = new XTagDocument($tag);
        $document->add('MY-LINE');

        $tag->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('tag1'));

        $this->assertSame("tag1\nMY-LINE", (string)$document);
    }
}
