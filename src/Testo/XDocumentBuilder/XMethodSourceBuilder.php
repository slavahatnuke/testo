<?php


namespace Testo\XDocumentBuilder;

use Testo\XDocument\XDocumentInterface;
use Testo\XDocument\XTagDocument;
use Testo\XDocument\XTagDocumentInterface;
use Testo\XSource\XMethodSource;
use Testo\XSource\XStringSource;

class XMethodSourceBuilder implements XDocumentBuilderInterface, XAwareBaseDocumentBuilderInterface
{

    /**
     * @var XDocumentBuilderInterface
     */
    protected $base_builder;

    public function supports(XDocumentInterface $document)
    {
        return $document instanceof XTagDocumentInterface
        && $document->getSource() instanceof XStringSource
        && !$document->getTag()->isBlock()
        && $document->getTag()->matchArgument(0, '/^[A-Z][\w]*/')
        && $document->getTag()->matchArgument(1, '/\w+/i');
    }

    /**
     * @param \Testo\XDocumentBuilder\XDocumentBuilderInterface $base_builder
     */
    public function setBaseBuilder(XDocumentBuilderInterface $base_builder)
    {
        $this->base_builder = $base_builder;
    }

    /**
     * @return \Testo\XDocumentBuilder\XDocumentBuilderInterface
     */
    public function getBaseBuilder()
    {
        return $this->base_builder;
    }

    public function build(XDocumentInterface $document)
    {
        $this->buildDocument($document);
    }

    protected function buildDocument(XTagDocumentInterface $document)
    {

        $method_document = new XTagDocument($document->getTag(),
            new XMethodSource(
                $document->getTag()->getArgument(0),
                $document->getTag()->getArgument(1)
            )
        );

        $document->add($method_document);

        $this->getBaseBuilder()->build($method_document);
    }


}