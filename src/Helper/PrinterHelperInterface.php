<?php

namespace Kematjaya\EscposBundle\Helper;

use Kematjaya\EscposBundle\Formatter\FormatterInterface;
use Kematjaya\EscposBundle\Client\ClientInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface PrinterHelperInterface 
{
    public function print(FormatterInterface $formatter, ClientInterface $client):void;
    
}
