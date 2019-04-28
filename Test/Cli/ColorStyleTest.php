<?php declare(strict_types=1);
/**
 * Part of Windwalker project Test files.  @codingStandardsIgnoreStart
 *
 * @copyright  Copyright (C) 2019 LYRASOFT Taiwan, Inc.
 * @license    LGPL-2.0-or-later
 */

namespace Windwalker\IO\Test\Cli;

use Windwalker\IO\Cli\Color\ColorStyle;

/**
 * Test class of ColorStyle
 *
 * @since 2.0
 */
class ColorStyleTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test instance.
     *
     * @var ColorStyle
     */
    protected $instance;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->instance = new ColorStyle('red', 'white', ['blink']);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown(): void
    {
    }

    /**
     * Test the GetStyle method.
     *
     * @covers \Windwalker\IO\Cli\Color\ColorStyle::getStyle
     *
     * @return void
     */
    public function testGetStyle()
    {
        $this->assertThat(
            $this->instance->getStyle(),
            $this->equalTo('31;47;5')
        );
    }

    /**
     * Test the ToString method.
     *
     * @return void
     */
    public function testToString()
    {
        $this->assertThat(
            $this->instance->__toString(),
            $this->equalTo('31;47;5')
        );
    }

    /**
     * Test the __construct method.
     *
     * @return void
     */
    public function fromString()
    {
        $style = new ColorStyle('white', 'red', ['blink', 'bold']);

        $this->assertThat(
            $this->instance->fromString('fg=white;bg=red;options=blink,bold'),
            $this->equalTo($style)
        );
    }

    /**
     * Test the fromString method.
     *
     * @return void
     */
    public function testFromStringInvalid()
    {
        $this->expectException(\RuntimeException::class);

        $this->instance->fromString('XXX;XX=YY');
    }

    /**
     * Test the __construct method.
     *
     * @return void
     */
    public function testConstructInvalid1()
    {
        $this->expectException(\InvalidArgumentException::class);

        new ColorStyle('INVALID');
    }

    /**
     * Test the __construct method.
     *
     * @return void
     */
    public function testConstructInvalid2()
    {
        $this->expectException(\InvalidArgumentException::class);

        new ColorStyle('', 'INVALID');
    }

    /**
     * Test the __construct method.
     *
     * @return void
     */
    public function testConstructInvalid3()
    {
        $this->expectException(\InvalidArgumentException::class);

        new ColorStyle('', '', ['INVALID']);
    }
}
