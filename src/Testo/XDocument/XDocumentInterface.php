<?php
namespace Testo\XDocument;

use Testo\XSource\XSourceInterface;
use Traversable;

interface XDocumentInterface extends \IteratorAggregate{

    /**
     * @return XSourceInterface
     */
    public function getSource();

    public function __toString();

    /**
     * @param String|XDocumentInterface $text
     */
    public function add($text);

    public function getIterator();

    public function isEmpty();

}