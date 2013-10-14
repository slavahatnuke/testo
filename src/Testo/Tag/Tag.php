<?php

namespace Testo\Tag;


class Tag implements TagInterface
{
    protected $content;

    protected $arguments;

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

    public function getArgument($index)
    {
        $this->defineArguments();
        return array_key_exists($index, $this->arguments) ? $this->arguments[$index] : null;
    }

    public function matchArgument($index, $regexp = '/.*/')
    {
        $argument = $this->getArgument($index);
        return !is_null($argument) && preg_match($regexp, $argument);
    }

    protected function defineArguments()
    {
        if (!$this->arguments) {
            $a = [];
            preg_match(self::$testo_tag, $this->getContent(), $a);
            $this->arguments = preg_split('/\s+/', $a[1]);
        }
    }


}