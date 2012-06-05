<?php

namespace Sf2gen\Bundle\ConsoleBundle\Command\Processor;

use Sf2gen\Bundle\ConsoleBundle\Command\CommandLine;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface AdapterInterface
{
    /**
     * @param \Sf2gen\Bundle\ConsoleBundle\Command\CommandLine $command
     */
    function process(CommandLine $command);
}
