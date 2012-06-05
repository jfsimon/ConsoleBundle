<?php

namespace Sf2gen\Bundle\ConsoleBundle\Command\Processor;

use Symfony\Component\HttpKernel\KernelInterface;
use Sf2gen\Bundle\ConsoleBundle\Command\CommandLine;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Sf2gen\Bundle\ConsoleBundle\Formatter\OutputFormatterHtml;
use Symfony\Bundle\FrameworkBundle\Console\Application;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ApplicationAdapter
{
    /**
     * @var string
     */
    private $kernelClass;

    /**
     * @var string
     */
    private $defaultEnv;

    /**
     * @param string $kernelClass
     * @param string $defaultEnv
     */
    public function __construct($kernelClass, $defaultEnv)
    {
        $this->kernelClass = $kernelClass;
        $this->defaultEnv  = $defaultEnv;
    }

    /**
     *  {@inheritdoc}
     */
    public function process(CommandLine $command)
    {
        $input  = new StringInput($command);
        $output = new StreamOutput(fopen("php://output", 'w'), StreamOutput::VERBOSITY_NORMAL, true, new OutputFormatterHtml(true));
        $env    = $input->getParameterOption(array('--env', '-e'), $this->defaultEnv);
        $debug  = !$input->hasParameterOption(array('--no-debug', ''));
        $app    = new Application(new $this->kernelClass($env, $debug));

        ob_start();
        $app->setAutoExit(false);
        $app->run($input, $output);

        return ob_get_clean();
    }
}
