<?php

namespace Testo\XDocumentBuilder;


interface XCompositeDocumentBuilderInterface extends XDocumentBuilderInterface
{

    public function addBuilder(XDocumentBuilderInterface $builder);

}