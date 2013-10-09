<?php


namespace Testo\XSource;

use Testo\Exception\SourceNotFoundException;

class XMethodSource implements XSourceInterface
{

    protected $class;

    protected $method;

    public function __construct($class, $method)
    {
        $this->class = $class;
        $this->method = $method;
    }


    /**
     * @return String
     */
    public function getContent()
    {
        try {
            return $this->getMethodCode(new \ReflectionMethod($this->class, $this->method));
        } catch (\ReflectionException $e) {
            throw new SourceNotFoundException('Method is not found: ' . $this->class . '::' . $this->method);
        }
    }

    /**
     * @param \ReflectionMethod $reflectionMethod
     *
     * @return array
     */
    protected function getMethodCode(\ReflectionMethod $reflectionMethod)
    {
        $file = file_get_contents($reflectionMethod->getFileName());

        $file = explode("\n", $file);
        $lines = array();

        foreach (range($reflectionMethod->getStartLine(), $reflectionMethod->getEndLine() - 1) as $line) {
            $lines[] = $file[$line];
        }

        $content = join("\n", array_values($lines));

        $content = preg_replace('/^\s*{\s*?\n?/','', $content);
        $content = preg_replace('/\n?\s*?}\s*$/','', $content);

        return $content;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->getContent();
    }


}