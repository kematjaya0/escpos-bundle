<?php

namespace Kematjaya\EscposBundle\Helper;

use Kematjaya\EscposBundle\Client\ClientInterface;
use Kematjaya\EscposBundle\Formatter\FormatterInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface PrinterHelperInterface
{
    public function print(FormatterInterface $formatter, ClientInterface $client): void;

}
