<?php


namespace Testo\XDocumentBuilder;


class XDocumentBuilderTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function build()
    {
        $base_builder = $this->newBuilder();

        $doc = $this->getMock('Testo\XDocument\XDocumentInterface');

        $source = $this->getMock('Testo\XSource\XSourceInterface');

        $doc->expects($this->once())
            ->method('getSource')
            ->will($this->returnValue($source));

        $source->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue(''));


        $builder = new XDocumentBuilder($base_builder);
        $builder->build($doc);
    }


    /**
     * @test
     */
    public function buildTextLines()
    {
        $base_builder = $this->newBuilder();

        $content = 'some-line';

        $doc = $this->newDocumentWithContent($content);

        $builder = new XDocumentBuilder($base_builder);

        $doc->expects($this->once())
            ->method('add')
            ->with($content);

        $builder->build($doc);

    }


    /**
     * @test
     */
    public function buildTestoLines()
    {
        $base_builder = $this->newBuilder();

        $content = '@testo some-tag';

        $doc = $this->newDocumentWithContent($content);

        $builder = new XDocumentBuilder($base_builder);

        $that = $this;
        
        $doc->expects($this->once())
            ->method('add')
            ->will($this->returnCallback(function($doc) use ($that, $content) {
                $that->assertSame($content, (string)$doc);
            }));

        $builder->build($doc);

    }


    /**
     * @test
     */
    public function buildTestoBlock()
    {

        $base_builder = new XCompositeDocumentBuilder();

        $content = "@testo some-block {\n\n some code \n \n@testo }";

        $doc = $this->newDocumentWithContent($content);

        $builder = new XDocumentBuilder($base_builder);
        $base_builder->addBuilder($builder);

        $that = $this;

        $doc->expects($this->once())
            ->method('add')
            ->will($this->returnCallback(function($doc) use ($that, $content) {
                $that->assertSame($content, (string)$doc);
            }));

        $builder->build($doc);

    }

    /**
     * @param $content
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function newDocumentWithContent($content)
    {
        $doc = $this->newDocument();

        $source = $this->getMock('Testo\XSource\XSourceInterface');

        $doc->expects($this->once())
            ->method('getSource')
            ->will($this->returnValue($source));


        $source->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($content));
        return $doc;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function newDocument()
    {
        return $this->getMock('Testo\XDocument\XDocumentInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function newBuilder()
    {
        return $this->getMock('Testo\XDocumentBuilder\XDocumentBuilderInterface');
    }
}
