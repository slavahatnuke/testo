<?php


namespace Testo\XDocumentBuilder;

use Testo\Tag\Tag;
use Testo\XDocument\XDocumentInterface;
use Testo\XDocument\XTagDocument;

class XDocumentBuilder implements XDocumentBuilderInterface, XAwareBaseDocumentBuilderInterface
{

    protected $line_separator = "\n";

    /**
     * @var XDocumentBuilderInterface
     */
    protected $base_builder;

    public function supports(XDocumentInterface $document)
    {
        return $document instanceof XDocumentInterface && $document->getSource();
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

    /**
     * @param XDocumentInterface $document
     * @return array
     */
    protected function extractLines(XDocumentInterface $document)
    {
        return $document->getSource() ?  explode($this->line_separator, $document->getSource()->getContent()) : [];
    }

    /**
     * @param XDocumentInterface $document
     */
    protected function buildDocument(XDocumentInterface $document)
    {

        foreach ($this->extractLines($document) as $line) {

            if (Tag::isTag($line)) {

                $doc = new XTagDocument(new Tag($line));
                $document->add($doc);

                $this->getBaseBuilder()->build($doc);

            } else {
                $document->add($line);
            }


        }
    }

}