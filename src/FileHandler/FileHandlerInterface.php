<?php

namespace Kematjaya\EscposBundle\FileHandler;

use Kematjaya\EscposBundle\Formatter\FormatterInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface FileHandlerInterface
{
    public function handle(FormatterInterface $formatter): Response;
}
