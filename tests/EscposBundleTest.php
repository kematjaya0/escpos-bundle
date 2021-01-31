<?php

/**
 * This file is part of the esc-pos-bundle.
 */

namespace Kematjaya\EscposBundle\Tests;

use Kematjaya\EscposBundle\Client\DefaultClient;
use Kematjaya\EscposBundle\Formatter\TextFormatter;
use Kematjaya\EscposBundle\Helper\PrinterHelperInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @package Kematjaya\EscposBundle\Tests
 * @license https://opensource.org/licenses/MIT MIT
 * @author  Nur Hidayatullah <kematjaya0@gmail.com>
 */
class EscposBundleTest extends WebTestCase
{
    public static function getKernelClass() 
    {
        return AppKernelTest::class;
    }
    
    public function testInstanceClass():ContainerInterface
    {
        $client = parent::createClient();
        $container = $client->getContainer();
        $this->assertInstanceOf(ContainerInterface::class, $container);
        
        return $container;
    }
    
    /**
     * @depends testInstanceClass
     * @param ContainerInterface $container
     * @return PrinterHelperInterface
     */
    public function testHelperInstance(ContainerInterface $container): PrinterHelperInterface
    {
        $this->assertTrue($container->has('printer_helper'));
        return $container->get('printer_helper');
    }
    
    /**
     * @depends testHelperInstance
     * @param PrinterHelperInterface $helper
     */
    public function testPrintException(PrinterHelperInterface $helper)
    {
        $formatter = new TextFormatter();
        $formatter->addText("test");
        
        $client = new DefaultClient();
        $client->setComputerName("Local")
                ->setPrinterName("POS-58");
        
        $this->expectException(\Exception::class);
        $helper->print($formatter, $client);
    }
}
