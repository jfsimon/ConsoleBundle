<?php

namespace Sf2gen\Bundle\ConsoleBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Sf2gen\Bundle\ConsoleBundle\Command\CommandLine;
use Sf2gen\Bundle\ConsoleBundle\Command\CommandProcessor;

/**
 * Controller for console
 *
 * @author Cédric Lahouste
 * @author Nicolas de Marqué
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @api
 */
class ConsoleController
{
    /**
     * @var \Sf2gen\Bundle\ConsoleBundle\Command\CommandProcessor
     */
    private $processor;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    private $templating;

    /**
     * @param \Sf2gen\Bundle\ConsoleBundle\Command\CommandProcessor $processor
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     */
    public function __construct(CommandProcessor $processor, EngineInterface $templating)
    {
        $this->processor  = $processor;
        $this->templating = $templating;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function processAction(Request $request)
    {
        if (!($request->isXmlHttpRequest() && 'POST' === $request->getMethod())) {
            throw new NotFoundHttpException();
        }

        try {
            $response = $this->processor->process(new CommandLine($request->request->get('command')));
        } catch (\Exception $e) {
            $response = $e->getMessage();
        }

        return new Response($response);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toolbarAction(Request $request)
    {
        if (null !== $session = $request->getSession()) {
            // keep current flashes for one more request
            $session->setFlashes($session->getFlashes());
        }

        $position = false === strpos($request->headers->get('user-agent'), 'Mobile') ? 'fixed' : 'absolute';

        return $this->templating->renderResponse('Sf2genConsoleBundle:Console:toolbar.html.twig', array(
            'position'     => $position,
            'apps'         => $this->container->getParameter('sf2gen_console.apps'),
        ));
    }
}
