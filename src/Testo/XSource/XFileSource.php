<?php


namespace Testo\XSource;


use Testo\Exception\SourceNotFoundException;

class XFileSource implements XSourceInterface
{

    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @return String
     */
    public function getContent()
    {
        if (!is_file($this->path)) {
            throw new SourceNotFoundException('File is not exist: ' . $this->path);
        }

        return file_get_contents($this->path);
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->path;
    }


}