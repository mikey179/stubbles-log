<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\log
 */
namespace stubbles\log\appender;
use stubbles\log\LogEntry;
/**
 * A log appenders that stores log entries in memory.
 */
class MemoryLogAppender implements LogAppender
{
    /**
     * stores the logged entries and represents the storing medium (memory)
     *
     * @type  array
     */
    protected $logEntries = [];

    /**
     * counts log entries for a certain target
     *
     * @api
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
     * @api
     * @param   string  $target
     * @param   int     $position
     * @return  string[]
     * @since   1.1.0
     */
    public function getLogEntryData($target, $position)
    {
        if (!isset($this->logEntries[$target])) {
            return [];
        }

        if (!isset($this->logEntries[$target][$position])) {
            return [];
        }

        return $this->logEntries[$target][$position]->data();
    }

    /**
     * returns list of log entries
     *
     * @api
     * @param   string  $target  optional
     * @return  \stubbles\log\LogEntry[]
     */
    public function getLogEntries($target)
    {
        if (!isset($this->logEntries[$target])) {
            return [];
        }

        return $this->logEntries[$target];
    }

    /**
     * stores log entry in memory
     *
     * @param   \stubbles\log\LogEntry  $logEntry
     * @return  \stubbles\log\appender\MemoryLogAppender
     */
    public function append(LogEntry $logEntry)
    {
        $this->logEntries[$logEntry->target()][] = $logEntry;
        return $this;
    }

    /**
     * finalize the log target
     *
     * @return  \stubbles\log\appender\MemoryLogAppender
     */
    public function finalize()
    {
        $this->logEntries = [];
        return $this;
    }
}
