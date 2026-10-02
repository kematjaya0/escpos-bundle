<?php

namespace Kematjaya\EscposBundle\FileHandler;

use Kematjaya\EscposBundle\Formatter\FormatterInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class TextFileHandler implements FileHandlerInterface
{
    public function handle(FormatterInterface $formatter, string $fileName = 'file.txt'): Response
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'kmj-escpos');
        $header = $formatter->getHeader();
        file_put_contents($tempFile, (null !== $header ? $header . PHP_EOL : '') . $formatter->getText());

        $response = new BinaryFileResponse($tempFile);
        $response->deleteFileAfterSend(true);
        $response->headers->set('Content-Type', 'text/plain; charset=UTF-8');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, '' !== $fileName ? $fileName : 'file.txt');

        return $response;
    }

}
