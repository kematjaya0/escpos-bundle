<?php

namespace Kematjaya\EscposBundle\FileHandler;

use Kematjaya\EscposBundle\Formatter\FormatterInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface FileHandlerInterface 
{
    public function handle(FormatterInterface $formatter);
}
