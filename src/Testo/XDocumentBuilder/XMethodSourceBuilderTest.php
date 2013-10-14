<?php


namespace Testo\XDocumentBuilder;


use Testo\Tag\Tag;
use Testo\XDocument\XTagDocumentInterface;
use Testo\XSource\XMethodSource;

class XMethodSourceBuilderTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function supports()
    {
        $builder = new XMethodSourceBuilder();

        $document = $this->getMock('Testo\XDocument\XTagDocumentInterface');

        $tag = new Tag("@testo NS1\\NS11\\ClassName methodName");

        $document->expects($this->any())
            ->method('getTag')
            ->will($this->returnValue($tag));

        $document->expects($this->any())
            ->method('isEmpty')
            ->will($this->returnValue(true));

        $this->assertTrue($builder->supports($document));
    }

    /**
     * @test
     */
    public function build()
    {
        $builder = new XMethodSourceBuilder();

        $base_builder = $this->getMock('Testo\XDocumentBuilder\XDocumentBuilderInterface');
        $builder->setBaseBuilder($base_builder);

        $document = $this->getMock('Testo\XDocument\XTagDocumentInterface');

        $tag = new Tag('@testo Testo\Tests\x_files\Example helloWorld');

        $document->expects($this->any())
            ->method('getTag')
            ->will($this->returnValue($tag));

        $that = $this;

        $document->expects($this->at(0))
            ->method('add');


        $document->expects($this->at(1))
            ->method('add')
            ->will($this->returnCallback(function($doc) use ($that, $tag){
                $that->assertSame($tag, $doc->getTag());
                $that->assertTrue($doc->getSource() instanceof XMethodSource);
                $this->assertContains('->say()', $doc->getSource()->getContent());
            }));

        $builder->build($document);

    }
}
