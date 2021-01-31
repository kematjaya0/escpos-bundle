<?php

namespace Kematjaya\EscposBundle\Helper;

use Kematjaya\EscposBundle\Formatter\FormatterInterface;
use Kematjaya\EscposBundle\Printer\PrinterInterface;
use Kematjaya\EscposBundle\Client\ClientInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class PrinterHelper implements PrinterHelperInterface
{
    
    /**
     * 
     * @var PrinterInterface
     */
    private $printer;
    
    public function __construct(PrinterInterface $printer) 
    {
        $this->printer = $printer;
    }
    
    public function print(FormatterInterface $formatter, ClientInterface $client):void
    {
        $this->printer->print($formatter, $client);
    }
}
