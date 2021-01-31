<?php

namespace Kematjaya\EscposBundle\Printer;

use Kematjaya\EscposBundle\Formatter\FormatterInterface;
use Kematjaya\EscposBundle\Client\ClientInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface PrinterInterface 
{
    public function print(FormatterInterface $formatter, ClientInterface $client):void;
}
