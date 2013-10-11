<?php


namespace Testo\XDocumentBuilder;


use Testo\XDocument\XDocument;
use Testo\XDocument\XDocumentInterface;
use Testo\XSource\XStringSource;

class XCompositeDocumentBuilder implements XDocumentBuilderInterface
{

    /**
     * @var array|XDocumentBuilderInterface[]
     */
    protected $builders = [];

    public function addBuilder(XDocumentBuilderInterface $builder)
    {
        $this->builders[] = $builder;

        if ($builder instanceof XAwareBaseDocumentBuilderInterface) {
            $builder->setBaseBuilder($this);
        }

    }

    public function supports(XDocumentInterface $document)
    {
        foreach ($this->builders as $builder) {
            if ($builder->supports($document)) {
                return true;
            }
        }
        return false;
    }

    public function build(XDocumentInterface $document)
    {

        foreach ($this->builders as $builder) {

            if ($builder->supports($document)) {
                $builder->build($document);
            }
        }

    }

}