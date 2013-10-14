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

        $source = $this->getMock('Testo\XSource\XStringSource');

        $document->expects($this->once())
            ->method('getSource')
            ->will($this->returnValue($source));

        $tag = new Tag("@testo NS1\\NS11\\ClassName methodName");

        $document->expects($this->any())
            ->method('getTag')
            ->will($this->returnValue($tag));

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

        $document->expects($this->once())
            ->method('add')
            ->will($this->returnCallback(function(XTagDocumentInterface $doc) use ($that, $tag){
                $that->assertSame($tag, $doc->getTag());
                $that->assertTrue($doc->getSource() instanceof XMethodSource);
                $this->assertContains('->say()', $doc->getSource()->getContent());
            }));

        $builder->build($document);

    }
}
