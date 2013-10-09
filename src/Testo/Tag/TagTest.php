<?php


namespace Testo\Tag;


class TagTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function getContent()
    {
        $content = 'xxx';
        $tag = new Tag($content);
        $this->assertSame($content, $tag->getContent());
    }

    /**
     * @test
     */
    public function isTag()
    {
        $this->assertTrue(Tag::isTag('@testo '));
        $this->assertFalse(Tag::isTag('@testo'));
        $this->assertFalse(Tag::isTag('testo'));
    }

    /**
     * @test
     */
    public function isBlockStart()
    {
        $this->assertTrue(Tag::isBlockStart('@testo {'));
        $this->assertTrue(Tag::isBlockStart('@testo any words {'));

        $this->assertFalse(Tag::isBlockStart('@testo '));
        $this->assertFalse(Tag::isBlockStart('@testo any words'));
    }


    /**
     * @test
     */
    public function isBlockEnd()
    {
        $this->assertTrue(Tag::isBlockEnd('@testo }'));
        $this->assertTrue(Tag::isBlockEnd('@testo any words }'));

        $this->assertFalse(Tag::isBlockEnd('@testo '));
        $this->assertFalse(Tag::isBlockEnd('@testo any words'));
    }

    /**
     * @test
     */
    public function testToString()
    {
        $content = 'xxx';
        $tag = new Tag($content);
        $this->assertSame($content, (string)$tag);
    }

}
