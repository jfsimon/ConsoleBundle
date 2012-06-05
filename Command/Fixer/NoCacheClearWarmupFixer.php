<?php

namespace Sf2gen\Bundle\ConsoleBundle\Command\Fixer;

use Sf2gen\Bundle\ConsoleBundle\Command\CommandLine;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class NoCacheClearWarmupFixer implements FixerInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(CommandLine $command)
    {
        return 'cache:clear' === $command->getCommand();
    }

    /**
     * {@inheritdoc}
     */
    public function fix(CommandLine $command)
    {
        $command->addParameter('--no-warmup');
    }
}
