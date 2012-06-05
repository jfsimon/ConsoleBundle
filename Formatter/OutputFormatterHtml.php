<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sf2gen\Bundle\ConsoleBundle\Formatter;

use Symfony\Component\Console\Formatter\OutputFormatter;

/**
 * Formatter class for console output.
 *
 * @author ndmf
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @api
 */
class OutputFormatterHtml extends OutputFormatter
{
    /**
     * {@inheritdoc}
     */
    public function __construct($decorated = null, array $styles = array())
    {
        $styles = array_merge(array(
            'error' => new OutputFormatterStyleHtml('white', 'red'),
            'info' => new OutputFormatterStyleHtml('green'),
            'comment' => new OutputFormatterStyleHtml('yellow'),
            'question' => new OutputFormatterStyleHtml('black', 'cyan'),
        ), $styles);

        parent::__construct($decorated, $styles);

        $this->getStyleStack()->setEmptyStyle(new OutputFormatterStyleHtml());
    }

    /**
     * {@inheritdoc}
     */
    public function format($message)
    {
        return sprintf('<pre>%s</pre>', parent::format($message));
    }
}
