<?php
namespace Testo\Tests;

use Testo\Testo;

class TestoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function provideTestData()
    {
        return array(
            array(__DIR__ . '/files/with_spaces.tpl', __DIR__ . '/files/with_spaces.txt'),
            array(__DIR__ . '/files/without_spaces.tpl', __DIR__ . '/files/without_spaces.txt'),
            array(__DIR__ . '/files/with_blocks.tpl', __DIR__ . '/files/with_blocks.txt'),
            array(__DIR__ . '/files/all_file.tpl', __DIR__ . '/files/all_file.txt'),
            array(__DIR__ . '/files/with_uncomment.tpl', __DIR__ . '/files/with_uncomment.txt'),
            array(__DIR__ . '/files/with_multiline_uncomment.tpl', __DIR__ . '/files/with_multiline_uncomment.txt'),
            array(__DIR__ . '/files/with_class.tpl', __DIR__ . '/files/with_class.txt'),
            array(
                __DIR__ . '/files/with_generated_valid_hash.tpl',
                __DIR__ . '/files/with_generated_valid_hash.txt'
            ),
        );
    }


    /**
     * @test
     *
     * @dataProvider provideTestData
     */
    public function shouldGenerateExpectedDocumentFromTemplate($documentFile, $expectedFile)
    {
        $documentFileCopy = $documentFile . '~';
        copy($documentFile, $documentFileCopy);

        $testo = new Testo();
        $testo->generate($documentFileCopy);

        $this->assertFileEquals($expectedFile, $documentFileCopy);
        unlink($documentFileCopy);
    }

    /**
     * @test
     * @expectedException \Testo\Exception\LogicException
     * @expectedExceptionMessage Block changed externally
     */
    public function shouldThrowExternalBlockChangeExceptionIfHashIsInvalid()
    {
        $file = __DIR__ . '/files/with_generated_invalid_hash.tpl';

        $testo = new Testo();
        $testo->generate($file);
    }


    /**
     * @return array
     */
    public function provideXTestData()
    {
        return array(
            array(__DIR__ . '/x_files/without_spaces.tpl', __DIR__ . '/x_files/without_spaces.txt'),
//            array(__DIR__ . '/x_files/with_spaces.tpl', __DIR__ . '/x_files/with_spaces.txt'),
//            array(__DIR__ . '/x_files/with_blocks.tpl', __DIR__ . '/x_files/with_blocks.txt'),
//            array(__DIR__ . '/x_files/all_file.tpl', __DIR__ . '/x_files/all_file.txt'),
//            array(__DIR__ . '/x_files/with_uncomment.tpl', __DIR__ . '/x_files/with_uncomment.txt'),
//            array(__DIR__ . '/x_files/with_multiline_uncomment.tpl', __DIR__ . '/x_files/with_multiline_uncomment.txt'),
//            array(__DIR__ . '/x_files/with_class.tpl', __DIR__ . '/x_files/with_class.txt'),
//            array(
//                __DIR__ . '/x_files/with_generated_valid_hash.tpl',
//                __DIR__ . '/x_files/with_generated_valid_hash.txt'
//            ),
        );
    }

    /**
     * @test
     *
     * dataProvider provideXTestData
     */
    public function shouldGenerateXDock($documentFile = 1, $expectedFile = 1)
    {
        $documentFile = __DIR__ . '/x_files/without_spaces.tpl';
        $expectedFile = __DIR__ . '/x_files/without_spaces.txt';

        $documentFileCopy = $documentFile . '~';
        copy($documentFile, $documentFileCopy);

        $testo = new Testo();
        $testo->xGenerate($documentFileCopy);


        $this->assertFileEquals($expectedFile, $documentFileCopy);
        unlink($documentFileCopy);
    }
}
