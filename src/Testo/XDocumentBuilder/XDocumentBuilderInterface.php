<?php


namespace Testo\XDocumentBuilder;


use Testo\XDocument\XDocumentInterface;

interface XDocumentBuilderInterface {

    public function addBuilder(XDocumentBuilderInterface $builder);

    public function build(XDocumentInterface $document);

    public function supports(XDocumentInterface $document);
}