<?php
namespace Testo\XDocument;

use Testo\XSource\XSourceInterface;

interface XDocumentInterface {

    /**
     * @return XSourceInterface
     */
    public function getSource();

    public function __toString();

    /**
     * @param String|XDocumentInterface $text
     */
    public function add($text);

}