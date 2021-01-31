<?php

namespace Kematjaya\EscposBundle\Printer;

use Kematjaya\EscposBundle\Exception\PrinterNotFoundException;
use Kematjaya\EscposBundle\Formatter\FormatterInterface;
use Kematjaya\EscposBundle\Printer\PrinterInterface;
use Kematjaya\EscposBundle\Client\ClientInterface;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class EscPOS implements PrinterInterface
{
    public function print(FormatterInterface $formatter, ClientInterface $client):void
    {
        try { 
            $connector = new WindowsPrintConnector($client->getConnectionName());
            $printer = new Printer($connector);
            
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $header = $formatter->getHeader();
            if (null !== $header) {
                $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                
                $printer->text("" . $header);
                $printer->selectPrintMode();
            }
            
            $printer->text("" . $formatter->getText());
            $printer->selectPrintMode();
            $printer->cut();
            $printer->close();
        } catch (\Exception $ex)  {
            if (false !== strpos(strtolower($ex->getMessage()), strtolower('Cannot initialise'))) {
                throw new PrinterNotFoundException($client->getPrinterName());
            }
            
            throw $ex;
        }
    }
}
