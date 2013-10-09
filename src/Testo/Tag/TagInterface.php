<?php

namespace Testo\Tag;


interface TagInterface
{

    /**
     * @param $text
     */
    static public function isTag($text);

    public function isStartBlock();

    public function isEndBlock();

    public function isBlock();


    public function getContent();

    public function __toString();

}