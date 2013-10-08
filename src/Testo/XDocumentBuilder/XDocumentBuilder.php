<?php


namespace Testo\XDocumentBuilder;


use Testo\XDocument\XDocument;
use Testo\XDocument\XDocumentInterface;
use Testo\XSource\XFileSource;
use Testo\XSource\XStringSource;

class XDocumentBuilder implements XDocumentBuilderInterface
{

    protected $testo_tag = '/@testo\s+/';

    /**
     * @var XDocumentBuilderInterface
     */
    protected $base_builder;

    public function __construct(XDocumentBuilderInterface $base_builder)
    {
        $this->base_builder = $base_builder;
    }

    public function supports(XDocumentInterface $document)
    {
        return $document->getSource() instanceof XFileSource;
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
        return explode("\n", $document->getSource()->getContent());
    }

    /**
     * @param $text
     */
    protected function isTestoLine($text)
    {
        return preg_match($this->testo_tag, $text);
    }

    /**
     * @param XDocumentInterface $document
     */
    protected function buildDocument(XDocumentInterface $document)
    {
        foreach ($this->extractLines($document) as $line) {

            if ($this->isTestoLine($line)) {

                $doc = new XDocument(new XStringSource($line));
                $this->base_builder->build($doc);

                $document->add($doc);

            } else {
                $document->add($line);
            }
        }
    }

}