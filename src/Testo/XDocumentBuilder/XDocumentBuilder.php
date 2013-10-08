<?php


namespace Testo\XDocumentBuilder;


use Testo\XDocument\XDocument;
use Testo\XDocument\XDocumentInterface;
use Testo\XSource\XStringSource;

class XDocumentBuilder implements XDocumentBuilderInterface
{

    /**
     * @var array|XDocumentBuilderInterface[]
     */
    protected $builders = [];

    protected $testo_tag = '/^(.*)@testo\s+(.*)$/';

    protected $testo_block_open = '/@testo.*?{/';

    protected $testo_block_close = '/@testo.*?}/';

    public function addBuilder(XDocumentBuilderInterface $builder)
    {
        $this->builders[] = $builder;
    }

    public function supports(XDocumentInterface $document)
    {
        return true;
    }

    public function build(XDocumentInterface $document)
    {

        foreach ($this->builders as $builder) {
            if ($builder->supports($document)) {
                return $builder->build($document);
            }
        }

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
//
//    /**
//     * @param $text
//     */
//    protected function isTestoBlockOpen($text)
//    {
//        return preg_match($this->testo_block_open, $text);
//    }
//
//    /**
//     * @param $text
//     */
//    protected function isTestoBlockClose($text)
//    {
//        return preg_match($this->testo_block_close, $text);
//    }

    /**
     * @param XDocumentInterface $document
     */
    protected function buildDocument(XDocumentInterface $document)
    {
        foreach ($this->extractLines($document) as $line) {

            if ($this->isTestoLine($line)) {

                $doc = new XDocument(new XStringSource($line));
//                $this->build($doc);

                $document->add($doc);

            } else {
                $document->add($line);
            }
        }
    }

}