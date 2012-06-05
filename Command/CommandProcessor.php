<?php

namespace Sf2gen\Bundle\ConsoleBundle\Command;

use Sf2gen\Bundle\ConsoleBundle\Command\Fixer\FixerInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class CommandProcessor
{
    /**
     * @var Fixer\FixerInterface[]
     */
    private $fixers;


    private $factory;

    public function __construct(AdapaterFactory $factory)
    {
        $this->fixers  = array();
        $this->factory = $factory;
    }

    /**
     * @param Fixer\FixerInterface $fixer
     */
    public function registerFixer(FixerInterface $fixer)
    {
        $this->fixers[] = $fixer;
    }

    public function process(CommandLine $command)
    {
        foreach ($this->fixers as $fixer) {
            if ($fixer->supports($command)) {
                $fixer->fix($command);
            }
        }

        return $this
            ->factory
            ->create($this->options)
            ->process($command);
    }
}
