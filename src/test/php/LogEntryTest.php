<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\log
 */
namespace stubbles\log;
/**
 * Test for stubbles\log\LogEntry.
 *
 * @group  core
 */
class LogEntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * instance to test
     *
     * @type  LogEntry
     */
    private $logEntry;
    /**
     * mocked logger instance
     *
     * @type  \PHPUnit_Framework_MockObject_MockObject
     */
    private $mockLogger;

    /**
     * set up test environment
     */
    public function setUp()
    {
        $this->mockLogger = $this->getMockBuilder('stubbles\log\Logger')
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $this->logEntry   = new LogEntry('testTarget', $this->mockLogger);
    }

    /**
     * @test
     */
    public function returnsGivenTarget()
    {
        $this->assertEquals('testTarget', $this->logEntry->target());
    }

    /**
     * @test
     */
    public function logDataIsInitiallyEmpty()
    {
        $this->assertEquals('', (string) $this->logEntry);
    }

    /**
     * @test
     */
    public function logCallsGivenLogger()
    {
        $this->mockLogger->expects($this->once())
                         ->method('log')
                         ->with($this->logEntry);
        $this->logEntry->log();
    }

    /**
     * @test
     * @since  1.1.0
     */
    public function logDelayedCallsGivenLogger()
    {
        $this->mockLogger->expects($this->once())
                         ->method('logDelayed')
                         ->with($this->logEntry);
        $this->logEntry->logDelayed();
    }

    /**
     * returns quoted data
     *
     * @return  array
     */
    public function getLogData()
    {
        return [['"bar"', '"bar'],
                ['foo"bar', 'foo"bar'],
                ['"baz"', '"baz"'],
                ['', '"'],
                ['foo', "fo\ro"],
                ['ba<nl>r', "ba\nr"],
                ['ba<nl>z', "ba\r\nz"],
                ['foobar;baz', 'foo' . LogEntry::DEFAULT_SEPERATOR . 'bar;baz'],
        ];
    }

    /**
     * @param  string  $expected
     * @param  string  $data
     * @test
     * @dataProvider  getLogData
     */
    public function loggedDataWillBeEscaped($expected, $data)
    {
        $this->assertEquals(
                [$expected],
                $this->logEntry->addData($data)
                               ->data()
        );
    }

    /**
     * @param  string  $expected
     * @param  string  $data
     * @test
     * @dataProvider  getLogData
     */
    public function loggedDataWillBeEscapedInLine($expected, $data)
    {
        $this->assertEquals(
                'foo' . LogEntry::DEFAULT_SEPERATOR . $expected . LogEntry::DEFAULT_SEPERATOR . 'bar',
                $this->logEntry->addData('foo')
                               ->addData($data)
                               ->addData('bar')
        );
    }

    /**
     * @param  string  $expected
     * @param  string  $data
     * @since  1.1.0
     * @test
     * @dataProvider  getLogData
     */
    public function loggedReplacedDataWillBeEscaped($expected, $data)
    {
        $this->assertEquals(
                [$expected],
                $this->logEntry->addData("test1")
                               ->replaceData(0, $data)
                               ->data()
        );
    }

    /**
     * @param  string  $expected
     * @param  string  $data
     * @since  1.1.0
     * @test
     * @dataProvider  getLogData
     */
    public function loggedReplacedDataWillBeEscapedInLine($expected, $data)
    {
        $this->assertEquals(
                'foo' . LogEntry::DEFAULT_SEPERATOR . $expected . LogEntry::DEFAULT_SEPERATOR . 'bar',
                $this->logEntry->addData('foo')
                               ->addData('baz')
                               ->addData('bar')
                               ->replaceData(1, $data)
        );
    }

    /**
     * @test
     */
    public function addDataRemovesDifferentSeperator()
    {
        $this->assertEquals(['foo' . LogEntry::DEFAULT_SEPERATOR . 'barbaz'],
                            $this->logEntry->setSeperator(';')
                                           ->addData('foo' . LogEntry::DEFAULT_SEPERATOR . 'bar;baz')
                                           ->data()
        );
    }

    /**
     * @since  1.1.0
     * @test
     */
    public function replaceDataRemovesDifferentSeperator()
    {
        $this->assertEquals(['foo' . LogEntry::DEFAULT_SEPERATOR . 'barbaz'],
                            $this->logEntry->setSeperator(';')
                                           ->addData('test')
                                           ->replaceData(0, 'foo' . LogEntry::DEFAULT_SEPERATOR . 'bar;baz')
                                           ->data()
        );
    }

    /**
     * @since  1.1.0
     * @test
     */
    public function replaceDataDoesNothingIfGivenPositionDoesNotExist()
    {
        $this->assertEquals([],
                            $this->logEntry->replaceData(0, "foo")
                                           ->data()
        );
    }
}
