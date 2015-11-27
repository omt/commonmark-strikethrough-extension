<?php

namespace OneMoreThing\CommonMark\Strikethrough\Tests\Functional;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use OneMoreThing\CommonMark\Strikethrough\StrikethroughExtension;

class StrikethroughTest extends \PHPUnit_Framework_TestCase
{

    /** @var CommonMarkConverter */
    protected $converter;

    protected function setUp()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new StrikethroughExtension());
        $this->converter = new Converter(
            new DocParser($environment),
            new HtmlRenderer($environment)
        );
    }

    public function provideTestCases()
    {
        return [
            ['~~Lorem ipsum~~', '<p><del>Lorem ipsum</del></p>'],
            ['~~dolor ~~', '<p>~~dolor ~~</p>'],
            ['~~sit~~~amet~~', '<p><del>sit</del>~amet~~</p>'],
            ['~~consectetuer~~~~adipiscing~~', '<p><del>consectetuer</del><del>adipiscing</del></p>']
        ];
    }

    /**
     * @dataProvider provideTestCases
     */
    public function testSimple($input, $expected)
    {
        $actual = $this->converter->convertToHtml($input);
        $actual = trim($actual);

        $this->assertEquals($expected, trim($actual));
    }
}
