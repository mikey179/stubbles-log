<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  net\stubbles\log
 */
namespace net\stubbles\log\appender;
use net\stubbles\lang\BaseObject;
use net\stubbles\log\LogEntry;
/**
 * A log appenders that stores log entries in memory.
 */
class MemoryLogAppender extends BaseObject implements LogAppender
{
    /**
     * stores the logged entries and represents the storing medium (memory)
     *
     * @type  array
     */
    protected $logEntries = array();

    /**
     * counts log entries for a certain target
     *
     * @param   string  $target
     * @return  int
     * @since   1.1.0
     */
    public function countLogEntries($target)
    {
        if (!isset($this->logEntries[$target])) {
            return 0;
        }

        return count($this->logEntries[$target]);
    }

    /**
     * returns data of a certain log entry
     *
     * @param   string  $target
     * @param   int     $position
     * @return  string[]
     * @since   1.1.0
     */
    public function getLogEntryData($target, $position)
    {
        if (!isset($this->logEntries[$target])) {
            return array();
        }

        if (!isset($this->logEntries[$target][$position])) {
            return array();
        }

        return $this->logEntries[$target][$position]->getData();
    }

    /**
     * returns list of log entries
     *
     * @param   string  $target  optional
     * @return  LogEntry[]
     */
    public function getLogEntries($target)
    {
        if (!isset($this->logEntries[$target])) {
            return array();
        }

        return $this->logEntries[$target];
    }

    /**
     * stores log entry in memory
     *
     * @param   LogEntry  $logEntry
     * @return  MemoryLogAppender
     */
    public function append(LogEntry $logEntry)
    {
        $this->logEntries[$logEntry->getTarget()][] = $logEntry;
        return $this;
    }

    /**
     * finalize the log target
     *
     * @return  MemoryLogAppender
     */
    public function finalize()
    {
        $this->logEntries = array();
        return $this;
    }
}
?>