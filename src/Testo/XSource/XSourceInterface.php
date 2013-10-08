<?php
namespace Testo\XSource;
use Testo\Exception\SourceNotFoundException;

interface XSourceInterface {

    /**
     * @return String
     * @throws SourceNotFoundException
     */
    public function getContent();

    /**
     * @return String
     */
    public function getName();
}