<?php


namespace Testo\XDocumentBuilder;

use Testo\Tag\Tag;
use Testo\XDocument\XDocumentInterface;
use Testo\XDocument\XTagDocument;
use Testo\XSource\XStringSource;

class XDocumentBuilder implements XDocumentBuilderInterface, XAwareBaseDocumentBuilderInterface
{

    protected $line_separator = "\n";

    /**
     * @var XDocumentBuilderInterface
     */
    protected $base_builder;

    public function supports(XDocumentInterface $document)
    {
        return $document instanceof XDocumentInterface;
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
        return explode($this->line_separator, $document->getSource()->getContent());
    }

    /**
     * @param XDocumentInterface $document
     */
    protected function buildDocument(XDocumentInterface $document)
    {

        $block_mode = false;
        $block_counter = 0;
        $block_tag = null;
        $block = [];

        foreach ($this->extractLines($document) as $line) {

            if (Tag::isTag($line)) {

                $tag = new Tag($line);

                if ($tag->isStartBlock()) {
                    $block_mode = true;

                    if (!$block_counter) {
                        $block_tag = $tag;
                    }
                    else{
                        $block[] = $line;
                    }

                    $block_counter++;
                }


                if (!$block_mode) {
                    $doc = new XTagDocument($tag);
                    $this->getBaseBuilder()->build($doc);
                    $document->add($doc);
                }

                if ($tag->isEndBlock()) {
                    $block_counter--;
                    if ($block_counter) {
                        $block[] = $line;
                    }
                }

                if ($block_mode && !$block_counter) {

                    $doc = new XTagDocument(
                        $block_tag,
                        new XStringSource(join($this->line_separator, $block)),
                        $tag);

                    $this->getBaseBuilder()->build($doc);
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