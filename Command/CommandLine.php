<?php

namespace Sf2gen\Bundle\ConsoleBundle\Command;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class CommandLine
{
    /**
     * @var string
     */
    private $command;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @param string $line
     */
    public function __construct($line)
    {
        $tokens = self::tokenize($line);

        $this->command    = array_shift($tokens);
        $this->parameters = $tokens;
    }

    public function __toString()
    {
        return $this->format();
    }

    /**
     * @param string $line
     *
     * @return array
     */
    static public function tokenize($line)
    {
        return array_map('trim', explode(' ', $line));
    }

    /**
     * @param string $command
     *
     * @return \Sf2gen\Bundle\ConsoleBundle\Command\CommandLine
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param array $parameters
     *
     * @return \Sf2gen\Bundle\ConsoleBundle\Command\CommandLine
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $parameter
     *
     * @return \Sf2gen\Bundle\ConsoleBundle\Command\CommandLine
     */
    public function addParameter($parameter)
    {
        $this->parameters[] = $parameter;

        return $this;
    }

    /**
     * @return string
     */
    public function format()
    {
        $parameters = count($this->parameters) ? ' '.implode(' ', $this->parameters) : '';

        return $this->command.$parameters;
    }
}
