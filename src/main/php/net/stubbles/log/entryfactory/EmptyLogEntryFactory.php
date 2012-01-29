<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  net\stubbles\log
 */
namespace net\stubbles\log\entryfactory;
use net\stubbles\log\LogEntry;
use net\stubbles\log\Logger;
/**
 * Factory which creates empty log entry containers.
 */
class EmptyLogEntryFactory extends AbstractLogEntryFactory
{
    /**
     * creates a log entry container
     *
     * @param   string  $target  target where the log data should go to
     * @param   Logger  $logger  logger instance to create log entry container for
     * @return  LogEntry
     */
    public function create($target, Logger $logger)
    {
        return new LogEntry($target, $logger);
    }
}
?>