<?php


namespace Testo\XDocumentBuilder;


class XCompositeDocumentBuilderTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function build()
    {
        $doc = $this->getMock('Testo\XDocument\XDocumentInterface');

        $builder = new XCompositeDocumentBuilder();
        $builder->build($doc);
    }

    /**
     * @test
     */
    public function supports()
    {
        $doc = $this->getMock('Testo\XDocument\XDocumentInterface');

        $builder = new XCompositeDocumentBuilder();
        $this->assertFalse($builder->supports($doc));
    }

    /**
     * @test
     */
    public function supportsExists()
    {
        $doc = $this->getMock('Testo\XDocument\XDocumentInterface');
        $sub_builder = $this->getMock('Testo\XDocumentBuilder\XDocumentBuilderInterface');

        $sub_builder->expects($this->once())
            ->method('supports')
            ->with($doc)
            ->will($this->returnValue(true));
        

        $builder = new XCompositeDocumentBuilder();
        $builder->addBuilder($sub_builder);

        $this->assertTrue($builder->supports($doc));
    }

    /**
     * @test
     */
    public function buildIfSubBuilderSupports()
    {
        $doc = $this->getMock('Testo\XDocument\XDocumentInterface');
        $sub_builder = $this->getMock('Testo\XDocumentBuilder\XDocumentBuilderInterface');

        $sub_builder->expects($this->once())
            ->method('supports')
            ->with($doc)
            ->will($this->returnValue(true));

        $sub_builder->expects($this->once())
            ->method('build')
            ->with($doc);


        $builder = new XCompositeDocumentBuilder();
        $builder->addBuilder($sub_builder);

        $builder->build($doc);
    }
}
