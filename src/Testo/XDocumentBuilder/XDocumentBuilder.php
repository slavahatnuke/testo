<?php


namespace Testo\XDocumentBuilder;

use Testo\XDocument\XDocument;
use Testo\XDocument\XDocumentInterface;
use Testo\XSource\XStringSource;

class XDocumentBuilder implements XDocumentBuilderInterface
{

    protected $testo_tag = '/@testo\s+/';

    protected $testo_block_start = '/@testo.*?{/';

    protected $testo_block_end = '/@testo.*?}/';
    
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
        return $document->getSource() instanceof XDocumentBuilderInterface
        && !($document->getSource() instanceof XStringSource);
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
     * @param $text
     */
    protected function isTestoLine($text)
    {
        return preg_match($this->testo_tag, $text);
    }

    /**
     * @param $text
     */
    protected function isTestoBlockStart($text)
    {
        return preg_match($this->testo_block_start, $text);
    }

    /**
     * @param $text
     */
    protected function isTestoBlockEnd($text)
    {
        return preg_match($this->testo_block_end, $text);
    }

    /**
     * @param XDocumentInterface $document
     */
    protected function buildDocument(XDocumentInterface $document)
    {

        $block_mode = false;
        $block = [];

        foreach ($this->extractLines($document) as $line) {

            if ($block_mode) {
                $block[] = $line;
            }

            if ($this->isTestoLine($line)) {

                if ($this->isTestoBlockStart($line)) {
                    $block_mode = true;
                    $block[] = $line;
                }

                if (!$block_mode) {
                    $doc = new XDocument(new XStringSource($line)); // TestoLineSource
                    $this->base_builder->build($doc);
                    $document->add($doc);
                }

                if ($this->isTestoBlockEnd($line)) {

                    $doc = new XDocument(new XStringSource(join($this->line_separator, $block))); // TestoBlockSource
                    $this->base_builder->build($doc);
                    $document->add($doc);

                    $block_mode = false;
                    $block = [];
                }


            } else if (!$block_mode) {
                $document->add($line);
            }
        }
    }

}