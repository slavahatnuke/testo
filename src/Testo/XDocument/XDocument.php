<?php

namespace Testo\XDocument;

use Testo\XSource\XSourceInterface;
use Testo\XSource\XStringSource;

class XDocument implements XDocumentInterface
{

    protected $source;

    protected $result = [];

    public function __construct(XSourceInterface $source = null)
    {
        $this->source = $source;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function __toString()
    {
        return join("\n", $this->getFinalResult());
    }

    /**
     * @param String|XDocumentInterface $text
     */
    public function add($text)
    {
        $this->result[] = $text;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->result);
    }

    public function isEmpty()
    {
        return !count($this->result);
    }

    /**
     * @return array
     */
    protected function getFinalResult()
    {
        $result = [];

        foreach ($this->result as $item) {

            if ($item instanceof XDocumentInterface) {
                if (!$item->isEmpty()) {
                    $result[] = $item;
                }
            } else {
                $result[] = $item;
            }

        }

        return $result;
    }


}