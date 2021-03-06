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
use stubbles\ioc\InjectionProvider;
use stubbles\log\appender\FileLogAppender;
/**
 * Injection provider for logger instances with a file appender.
 *
 * @since  2.0.0
 */
class FileBasedLoggerProvider implements InjectionProvider
{
    /**
     * logger instance provider
     *
     * @type  \stubbles\log\ioc\LoggerProvider
     */
    private $loggerProvider;
    /**
     * path where logfiles should be stored
     *
     * @type  string
     */
    private $logPath;
    /**
     * file mode for file appender
     *
     * @type  int
     */
    private $fileMode       = 0700;

    /**
     * constructor
     *
     * @param  \stubbles\log\ioc\LoggerProvider  $loggerProvider  provider which creates logger instances
     * @param  string                            $logPath         path where logfiles should be stored
     * @Inject
     * @Named{logPath}('stubbles.log.path')
     */
    public function __construct(LoggerProvider $loggerProvider, $logPath)
    {
        $this->loggerProvider = $loggerProvider;
        $this->logPath        = $logPath;
    }

    /**
     * sets the mode for new log directories
     *
     * @param   int  $fileMode
     * @return  \stubbles\log\ioc\FileBasedLoggerProvider
     * @Inject(optional=true)
     * @Named('stubbles.log.filemode')
     */
    public function setFileMode($fileMode)
    {
        $this->fileMode = $fileMode;
        return $this;
    }

    /**
     * returns the value to provide
     *
     * @param   string  $name  optional
     * @return  \stubbles\log\Logger
     */
    public function get($name = null)
    {
        $logger = $this->loggerProvider->get($name);
        if (!$logger->hasLogAppenders()) {
            $logger->addAppender(new FileLogAppender($this->logPath))
                   ->setMode($this->fileMode);
        }

        return $logger;
    }
}
