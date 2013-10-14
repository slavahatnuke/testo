<?php
namespace Testo\Tests\x_files;

class Example
{
    public function helloWorld()
    {
        $helloWorld = new \HelloWorld;

        $helloWorld->say();
    }

    public function exampleBlocks()
    {
        $helloWorld = new \HelloWorld;
        //@testo {
        $helloWorld->say();
        //@testo }
    }

    public function exampleUncomment()
    {

        //@testo uncomment use \Foo\Bar;
        $bar = new Bar;

        $bar->baz();

    }

    public function exampleMultiLineUncomment()
    {

        //@testo uncomment {
        //use \Foo\Bar;
        //use \Foo\Baz;
        //@testo uncomment }
        $bar = new Bar;

        $bar->baz();

    }
}