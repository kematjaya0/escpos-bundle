<?php

/**
 * This file is part of the esc-pos-bundle.
 */

namespace Kematjaya\EscposBundle\Tests;

use Kematjaya\EscposBundle\Client\DefaultClient;
use Kematjaya\EscposBundle\FileHandler\FileHandlerInterface;
use Kematjaya\EscposBundle\Formatter\TextFormatter;
use Kematjaya\EscposBundle\Helper\PrinterHelperInterface;
use Kematjaya\EscposBundle\Printer\PrinterInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @package Kematjaya\EscposBundle\Tests
 * @license https://opensource.org/licenses/MIT MIT
 * @author  Nur Hidayatullah <kematjaya0@gmail.com>
 */
class EscposBundleTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return AppKernel::class;
    }

    public function testServices(): void
    {
        $container = static::getContainer();
        $this->assertInstanceOf(PrinterHelperInterface::class, $container->get('test.printer_helper'));
        $this->assertInstanceOf(PrinterInterface::class, $container->get('test.printer'));
        $this->assertInstanceOf(FileHandlerInterface::class, $container->get('test.file_handler'));
    }

    public function testPrintToFile(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'kmj-escpos-out');
        $formatter = (new TextFormatter())->setHeader('TOKO')->addText('test')->addEnter();
        $client = (new DefaultClient())->setConnectionName('file://' . $file);

        static::getContainer()->get('test.printer_helper')->print($formatter, $client);

        $output = file_get_contents($file);
        unlink($file);
        $this->assertStringContainsString("TOKO\n", $output);
        $this->assertStringContainsString("test\n", $output);
        // GS V (cut)
        $this->assertStringContainsString("\x1dV", $output);
    }
}
