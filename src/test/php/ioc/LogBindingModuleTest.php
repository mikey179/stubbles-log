<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\log
 */
namespace stubbles\log\ioc;
use stubbles\ioc\Binder;
/**
 * Test for stubbles\log\ioc\LogBindingModule.
 *
 * @group  ioc
 */
class LogBindingModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * configures the bindings
     *
     * @param   LogBindingModule  $logBindingModule
     * @return  stubbles\ioc\Injector
     */
    private function configureBindings(LogBindingModule $logBindingModule)
    {
        $binder = new Binder();
        $logBindingModule->configure($binder);
        return $binder->getInjector();
    }

    /**
     * @test
     */
    public function logPathIsIsNotBoundWhenNotGiven()
    {
        $this->assertFalse($this->configureBindings(LogBindingModule::create())
                                ->hasConstant('stubbles.log.path')
        );
    }

    /**
     * @test
     */
    public function logPathIsBoundToProjectPathWhenGiven()
    {

        $this->assertSame(__DIR__ . DIRECTORY_SEPARATOR . 'log',
                          $this->configureBindings(LogBindingModule::createWithProjectPath(__DIR__))
                               ->getConstant('stubbles.log.path')
        );
    }

    /**
     * @test
     */
    public function logPathIsBoundWhenGiven()
    {
        $this->assertSame(__DIR__,
                          $this->configureBindings(LogBindingModule::createWithLogPath(__DIR__))
                               ->getConstant('stubbles.log.path')
        );
    }

    /**
     * @test
     */
    public function logEntryFactoryIsBoundAsSingleton()
    {
        $injector = $this->configureBindings(new LogBindingModule());
        $this->assertSame($injector->getInstance('stubbles\log\entryfactory\LogEntryFactory'),
                          $injector->getInstance('stubbles\log\entryfactory\LogEntryFactory')
        );
    }

    /**
     * @test
     */
    public function logEntryFactoryClassIsBoundToTimedLogEntryFactoryByDefault()
    {
        $this->assertInstanceOf('stubbles\log\entryfactory\TimedLogEntryFactory',
                                $this->configureBindings(LogBindingModule::create())
                                     ->getInstance('stubbles\log\entryfactory\LogEntryFactory')
        );
    }

    /**
     * @test
     */
    public function logEntryFactoryClassIsBoundToConfiguredLogEntryFactoryClass()
    {
        $this->assertInstanceOf('stubbles\log\entryfactory\EmptyLogEntryFactory',
                                $this->configureBindings(LogBindingModule::create()
                                                                         ->setLogEntryFactory('stubbles\log\entryfactory\EmptyLogEntryFactory')
                                       )
                                     ->getInstance('stubbles\log\entryfactory\LogEntryFactory')
        );
    }

    /**
     * @test
     */
    public function loggerCanBeCreated()
    {
        $this->assertInstanceOf('stubbles\log\Logger',
                                $this->configureBindings(LogBindingModule::createWithLogPath(__DIR__))
                                     ->getInstance('stubbles\log\Logger')
        );
    }

    /**
     * @test
     */
    public function loggerCanBeCreatedUsingDifferentLoggerProvider()
    {
        $this->assertInstanceOf('stubbles\log\Logger',
                                $this->configureBindings(LogBindingModule::createWithLogPath(__DIR__)
                                                                         ->setLoggerProvider('stubbles\log\ioc\LoggerProvider')
                                       )
                                     ->getInstance('stubbles\log\Logger')
        );
    }
}
