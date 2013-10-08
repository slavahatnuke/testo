<?php


namespace Testo\XDocumentBuilder;


class XDocumentBuilderTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function build()
    {
        $doc = $this->getMock('Testo\XDocument\XDocumentInterface');

        $source = $this->getMock('Testo\XSource\XSourceInterface');

        $doc->expects($this->once())
            ->method('getSource')
            ->will($this->returnValue($source));

        $source->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue(''));


        $builder = new XDocumentBuilder();
        $builder->build($doc);
    }

    /**
     * @test
     */
    public function buildWithSubBuilders()
    {
        $doc = $this->newDocument();

        $builder = new XDocumentBuilder();
        $sub_builder = $this->getMock('Testo\XDocumentBuilder\XDocumentBuilder');

        $sub_builder->expects($this->once())
            ->method('supports')
            ->with($doc)
            ->will($this->returnValue(true));

        $sub_builder->expects($this->once())
            ->method('build')
            ->with($doc);

        $builder->addBuilder($sub_builder);

        $builder->build($doc);
    }

    /**
     * @test
     */
    public function buildTextLines()
    {
        $content = 'some-line';

        $doc = $this->newDocumentWithContent($content);

        $builder = new XDocumentBuilder();

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
        $content = '@testo some-tag';

        $doc = $this->newDocumentWithContent($content);

        $builder = new XDocumentBuilder();

        $doc->expects($this->once())
            ->method('add')
            ->will($this->returnCallback(function($arg){
                $a=1;
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
}
