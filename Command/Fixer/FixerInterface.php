<?php

namespace Sf2gen\Bundle\ConsoleBundle\Command\Fixer;

use Sf2gen\Bundle\ConsoleBundle\Command\CommandLine;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
interface FixerInterface
{
    /**
     * @param \Sf2gen\Bundle\ConsoleBundle\Command\CommandLine $command
     *
     * @return bool
     */
    function supports(CommandLine $command);

    /**
     * @param \Sf2gen\Bundle\ConsoleBundle\Command\CommandLine $command
     */
    function fix(CommandLine $command);
}
