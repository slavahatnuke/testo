<?php


namespace Testo\XSource;

class XStringSource implements XSourceInterface
{

    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return String
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->getContent();
    }


}