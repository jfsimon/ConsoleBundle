<?php

namespace Sf2gen\Bundle\ConsoleBundle\Command\Processor;

use Symfony\Component\HttpKernel\KernelInterface;
use Sf2gen\Bundle\ConsoleBundle\Command\CommandLine;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ApplicationAdapter
{
    /**
     * @var string
     */
    private $rootDir;

    /**
     * @var string
     */
    private $console;

    /**
     * @param string $rootDir
     * @param string $console
     */
    public function __construct($rootDir, $console)
    {
        $this->rootDir = $rootDir;
        $this->console = $console;
    }

    /**
     *  {@inheritdoc}
     */
    public function process(CommandLine $command)
    {
        $options = array('suppress_errors' => false, 'bypass_shell' => false);
        $process = new Process($this->buildCommand($command), $this->rootDir, null, null, 30, $options);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException('Process failed.');
        }

        return $process->getOutput();
    }

    /**
     * @param \Sf2gen\Bundle\ConsoleBundle\Command\CommandLine $command
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    private function buildCommand(CommandLine $command)
    {
        $finder = new PhpExecutableFinder();
        $php    = $finder->find();

        if (empty($php)) {
            throw new \RuntimeException('PHP executable not found.');
        }

        return $php.' '.$this->console.' '.$command;
    }
}
