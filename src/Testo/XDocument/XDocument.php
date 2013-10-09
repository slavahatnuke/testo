<?php

namespace Testo\XDocument;

use Testo\XSource\XSourceInterface;
use Testo\XSource\XStringSource;

class XDocument implements XDocumentInterface {

    protected $source;

    protected $result = [];
    
    public function __construct(XSourceInterface $source = null)
    {

        if (!$source) {
            $source = new XStringSource();
        }

        $this->source = $source;
    }

    /**
     * @inheritdoc
     */
    public function getSource()
    {
        return $this->source;
    }

    public function __toString()
    {
        return $this->convert($this->result);
    }

    /**
     * @param String|XDocumentInterface $text
     */
    public function add($text)
    {
        $this->result[] = $text;
    }

    /**
     * @return string
     */
    protected function convert(array $result)
    {
        return join("\n", $result);
    }


}