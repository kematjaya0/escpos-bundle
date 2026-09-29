<?php

namespace Kematjaya\EscposBundle\Tests\Printer;

use Kematjaya\EscposBundle\Client\DefaultClient;
use Kematjaya\EscposBundle\Exception\PrinterNotFoundException;
use Kematjaya\EscposBundle\Formatter\TextFormatter;
use Kematjaya\EscposBundle\Printer\EscPOS;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use PHPUnit\Framework\TestCase;

class EscPOSTest extends TestCase
{
    private function call(string $method, DefaultClient $client)
    {
        $printer = new EscPOS();
        $reflection = new \ReflectionMethod($printer, $method);
        $reflection->setAccessible(true);

        return $reflection->invoke($printer, $client);
    }

    public function testDefaultConnectionIsWindowsShare()
    {
        $client = (new DefaultClient())->setComputerName('KASIR')->setPrinterName('POS-58');

        $this->assertSame('smb://guest@KASIR/POS-58', $client->getConnectionName());
        $connector = $this->call('createConnector', $client);
        $this->assertInstanceOf(WindowsPrintConnector::class, $connector);

        try {
            // smbclient tidak tersedia di container test
            $connector->finalize();
        } catch (\Exception $e) {
        }
    }

    public function testFileConnector()
    {
        $file = tempnam(sys_get_temp_dir(), 'kmj-escpos');
        $connector = $this->call('createConnector', (new DefaultClient())->setConnectionName('file://' . $file));
        $connector->finalize();
        unlink($file);

        $this->assertInstanceOf(FilePrintConnector::class, $connector);
    }

    public function testNetworkPrinterNotFound()
    {
        $client = (new DefaultClient())->setPrinterName('LAN')->setConnectionName('tcp://127.0.0.1:1');

        $this->expectException(PrinterNotFoundException::class);
        $this->expectExceptionMessage('printer not found : LAN');
        (new EscPOS())->print((new TextFormatter())->addText('x'), $client);
    }

    public function testProfile()
    {
        $client = new DefaultClient();
        $this->assertSame('POS-5890', $client->getPrinterProfileName());
        $this->assertSame('POS-5890', $this->call('createProfile', $client)->getId());

        $client->setPrinterProfileName('TM-T88V');
        $this->assertSame('TM-T88V', $this->call('createProfile', $client)->getId());

        $client->setPrinterProfileName('');
        $this->assertSame('default', $this->call('createProfile', $client)->getId());
    }

    public function testUnknownProfile()
    {
        $file = tempnam(sys_get_temp_dir(), 'kmj-escpos');
        $client = (new DefaultClient())->setConnectionName('file://' . $file)->setPrinterProfileName('tidak-ada');

        try {
            $this->expectException(\InvalidArgumentException::class);
            (new EscPOS())->print((new TextFormatter())->addText('x'), $client);
        } finally {
            unlink($file);
        }
    }
}
