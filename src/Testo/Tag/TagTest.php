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
        $tag = new Tag('@testo {');
        $this->assertTrue($tag->isStartBlock());

        $tag = new Tag('@testo any words {');
        $this->assertTrue($tag->isStartBlock());

        $tag = new Tag('@testo ');
        $this->assertFalse($tag->isStartBlock());

        $tag = new Tag('@testo any words');
        $this->assertFalse($tag->isStartBlock());
    }


    /**
     * @test
     */
    public function isBlockEnd()
    {
        $tag = new Tag('@testo }');
        $this->assertTrue($tag->isEndBlock());

        $tag = new Tag('@testo any words }');
        $this->assertTrue($tag->isEndBlock());

        $tag = new Tag('@testo ');
        $this->assertFalse($tag->isEndBlock('@testo '));

        $tag = new Tag('@testo any words');
        $this->assertFalse($tag->isEndBlock('@testo any words'));
    }

    /**
     * @test
     */
    public function isBlock()
    {
        $tag = new Tag('@testo }');
        $this->assertTrue($tag->isBlock());

        $tag = new Tag('@testo ');
        $this->assertFalse($tag->isBlock('@testo '));
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
