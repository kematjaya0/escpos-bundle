<?php

namespace Kematjaya\EscposBundle\Tests\FileHandler;

use Kematjaya\EscposBundle\FileHandler\TextFileHandler;
use Kematjaya\EscposBundle\Formatter\TextFormatter;
use PHPUnit\Framework\TestCase;

class TextFileHandlerTest extends TestCase
{
    public function testHandle()
    {
        $formatter = (new TextFormatter())->setHeader('TOKO')->setText('isi');
        $response = (new TextFileHandler())->handle($formatter, 'struk.txt');

        $file = $response->getFile()->getPathname();
        $this->assertSame('TOKO' . PHP_EOL . 'isi', file_get_contents($file));
        $this->assertSame('attachment; filename=struk.txt', $response->headers->get('content-disposition'));

        ob_start();
        $response->sendContent();
        ob_end_clean();
        $this->assertFileDoesNotExist($file);
    }

    public function testFormatter()
    {
        $formatter = (new TextFormatter())->addText('a')->addEnter()->addText('b');
        $this->assertSame('a' . PHP_EOL . 'b', $formatter->getText());
        $this->assertNull($formatter->clear()->getText());
    }
}
