<?php

namespace Kematjaya\EscposBundle\Exception;

use Exception;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class PrinterNotFoundException extends Exception
{
    public function __construct(string $printer)
    {
        $message = sprintf('printer not found : %s', $printer);
        parent::__construct($message);
    }
}
