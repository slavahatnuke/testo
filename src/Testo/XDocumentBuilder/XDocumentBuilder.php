<?php


namespace Testo\XDocumentBuilder;

use Testo\Tag\Tag;
use Testo\XDocument\XDocument;
use Testo\XDocument\XDocumentInterface;
use Testo\XDocument\XTagDocument;
use Testo\XSource\XStringSource;

class XDocumentBuilder implements XDocumentBuilderInterface
{

    protected $line_separator = "\n";

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
        return $document instanceof XDocumentInterface;
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
        return explode($this->line_separator, $document->getSource()->getContent());
    }

    /**
     * @param XDocumentInterface $document
     */
    protected function buildDocument(XDocumentInterface $document)
    {

        $block_mode = false;
        $block_tag = null;
        $block = [];

        foreach ($this->extractLines($document) as $line) {

            if (Tag::isTag($line)) {

                $tag = new Tag($line);

                if (Tag::isBlockStart($line)) {
                    $block_mode = true;
                    $block_tag = $tag;
                }


                if (!$block_mode) {
                    $doc = new XTagDocument($tag);
                    $this->base_builder->build($doc);
                    $document->add($doc);
                }

                if (Tag::isBlockEnd($line)) {

                    $source = new XStringSource(join($this->line_separator, $block));
                    $doc = new XTagDocument($block_tag, $source, $tag);

                    $this->base_builder->build($doc);
                    $document->add($doc);

                    $block_tag = null;
                    $block_mode = false;
                    $block = [];
                }


            } else if ($block_mode) {
                $block[] = $line;
            } else if (!$block_mode) {
                $document->add($line);
            }


        }
    }

}