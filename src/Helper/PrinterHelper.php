<?php

namespace Kematjaya\EscposBundle\Helper;

use Kematjaya\EscposBundle\Client\ClientInterface;
use Kematjaya\EscposBundle\Formatter\FormatterInterface;
use Kematjaya\EscposBundle\Printer\PrinterInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class PrinterHelper implements PrinterHelperInterface
{
    public function __construct(private readonly PrinterInterface $printer) {}

    public function print(FormatterInterface $formatter, ClientInterface $client): void
    {
        $this->printer->print($formatter, $client);
    }
}
