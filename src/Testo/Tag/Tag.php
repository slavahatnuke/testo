<?php

namespace Testo\Tag;


class Tag implements TagInterface
{
    protected $content;

    static protected $testo_tag = '/@testo\s+(.*)/';

    static protected $testo_block_start = '/@testo.*?{/';

    static protected $testo_block_end = '/@testo.*?}/';

    /**
     * @param $text
     */
    static public function isTag($text)
    {
        return preg_match(self::$testo_tag, $text) ? true : false;
    }

    /**
     * @param $text
     */
    static public function isBlockStart($text)
    {
        return preg_match(self::$testo_block_start, $text) ? true : false;
    }

    /**
     * @param $text
     */
    static public function isBlockEnd($text)
    {
        return preg_match(self::$testo_block_end, $text) ? true : false;
    }


    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function __toString()
    {
        return $this->getContent();
    }

}