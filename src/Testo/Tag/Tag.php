<?php

namespace Testo\Tag;


class Tag implements TagInterface
{
    protected $content;

    static protected $testo_tag = '/@testo\s+(.*)/';

    static protected $testo_start_block = '/@testo.*?{/';

    static protected $testo_end_block = '/@testo.*?}/';

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
    public function isStartBlock()
    {
        return preg_match(self::$testo_start_block, $this->content) ? true : false;
    }

    /**
     * @param $text
     */
    public function isEndBlock()
    {
        return preg_match(self::$testo_end_block, $this->content) ? true : false;
    }

    public function isBlock()
    {
        return $this->isStartBlock() || $this->isEndBlock();
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