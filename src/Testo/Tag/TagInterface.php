<?php

namespace Testo\Tag;


interface TagInterface
{

    /**
     * @param $text
     */
    static public function isTag($text);

    /**
     * @param $text
     */
    static public function isBlockStart($text);

    /**
     * @param $text
     */
    static public function isBlockEnd($text);


    public function getContent();

    public function __toString();

}