<?php

namespace Testo\XDocument;

use Testo\Tag\TagInterface;

interface XTagDocumentInterface extends XDocumentInterface
{

    /**
     * @param \Testo\Tag\TagInterface $tag
     */
    public function setTag(TagInterface $tag);

    /**
     * @return \Testo\Tag\TagInterface
     */
    public function getTag();

    /**
     * @param \Testo\Tag\TagInterface $end_tag
     */
    public function setEndTag(TagInterface $end_tag);

    /**
     * @return \Testo\Tag\TagInterface
     */
    public function getEndTag();

}