<?php

namespace Testo\XDocumentBuilder;


interface XAwareBaseDocumentBuilderInterface
{

    public function setBaseBuilder(XDocumentBuilderInterface $builder);

    public function getBaseBuilder();

}