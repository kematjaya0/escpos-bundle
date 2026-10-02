<?php

namespace Kematjaya\EscposBundle\Printer;

use Kematjaya\EscposBundle\Client\ClientInterface;
use Kematjaya\EscposBundle\Exception\PrinterNotFoundException;
use Kematjaya\EscposBundle\Formatter\FormatterInterface;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\PrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class EscPOS implements PrinterInterface
{
    public const DEFAULT_NETWORK_PORT = 9100;

    public function print(FormatterInterface $formatter, ClientInterface $client): void
    {
        $printer = null;
        $profile = $this->createProfile($client);
        try {
            $printer = new Printer($this->createConnector($client), $profile);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $header = $formatter->getHeader();
            if (null !== $header) {
                $printer->selectPrintMode(Printer::MODE_EMPHASIZED);

                $printer->text("" . $header);
                if (!str_ends_with($header, "\n")) {
                    $printer->feed();
                }

                $printer->selectPrintMode();
            }

            $printer->text("" . $formatter->getText());
            $printer->selectPrintMode();
            $printer->cut();
        } catch (\Exception $ex) {
            if (str_contains(strtolower($ex->getMessage()), strtolower('Cannot initialise'))) {
                throw new PrinterNotFoundException((string) $client->getPrinterName());
            }

            throw $ex;
        } finally {
            if (null !== $printer) {
                $printer->close();
            }
        }
    }

    /**
     * Create connector from client connection name:
     * - tcp://host[:port]     network printer (default port 9100)
     * - cups://printer-name   CUPS printer
     * - file:///dev/usb/lp0   file / device
     * - lainnya (smb://..., LPT1, nama printer windows) memakai WindowsPrintConnector
     */
    protected function createConnector(ClientInterface $client): PrintConnector
    {
        $connection = (string) $client->getConnectionName();
        $scheme = strtolower((string) parse_url($connection, PHP_URL_SCHEME));
        switch ($scheme) {
            case 'tcp':
                $port = parse_url($connection, PHP_URL_PORT);

                return new NetworkPrintConnector((string) parse_url($connection, PHP_URL_HOST), $port ? (int) $port : self::DEFAULT_NETWORK_PORT);
            case 'cups':
                return new CupsPrintConnector(substr($connection, strlen('cups://')));
            case 'file':
                return new FilePrintConnector(substr($connection, strlen('file://')));
        }

        return new WindowsPrintConnector($connection);
    }

    /**
     * Create capability profile from client profile name, default profile when empty
     */
    protected function createProfile(ClientInterface $client): CapabilityProfile
    {
        $profile = $client->getPrinterProfileName();

        return CapabilityProfile::load(null !== $profile && '' !== $profile ? $profile : 'default');
    }
}
