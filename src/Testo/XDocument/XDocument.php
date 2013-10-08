<?php

namespace Testo\XDocument;

use Testo\XSource\XSourceInterface;

class XDocument implements XDocumentInterface {


    protected $source;

    protected $result = [];
    
    public function __construct(XSourceInterface $source)
    {
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
        return join("\n", $this->result);
    }

    /**
     * @param String|XDocumentInterface $text
     */
    public function add($text)
    {
        $this->result[] = $text;
    }


}