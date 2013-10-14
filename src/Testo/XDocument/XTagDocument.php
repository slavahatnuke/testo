<?php

namespace Testo\XDocument;

use Testo\Tag\TagInterface;
use Testo\XSource\XSourceInterface;

class XTagDocument extends XDocument implements XTagDocumentInterface
{

    /**
     * @var \Testo\Tag\TagInterface
     */
    protected $tag;

    /**
     * @var \Testo\Tag\TagInterface|null
     */
    protected $end_tag;

    public function __construct(TagInterface $tag, XSourceInterface $source = null, TagInterface $end_tag = null)
    {
        $this->tag = $tag;
        $this->end_tag = $end_tag;
        parent::__construct($source);
    }


    /**
     * @param \Testo\Tag\TagInterface $tag
     */
    public function setTag(TagInterface $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return \Testo\Tag\TagInterface
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param \Testo\Tag\TagInterface $end_tag
     */
    public function setEndTag(TagInterface $end_tag)
    {
        $this->end_tag = $end_tag;
    }

    /**
     * @return \Testo\Tag\TagInterface
     */
    public function getEndTag()
    {
        return $this->end_tag;
    }

}