<?php

namespace Kematjaya\EscposBundle\FileHandler;

use Kematjaya\EscposBundle\Formatter\FormatterInterface;
use Kematjaya\EscposBundle\FileHandler\FileHandlerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class TextFileHandler implements FileHandlerInterface 
{
    public function handle(FormatterInterface $formatter, string $fileName = 'file.txt') :Response
    {
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        file_put_contents($tempFile, $formatter->getText());
        
        $response = new BinaryFileResponse($tempFile);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, null === $fileName ? $response->getFile()->getFilename() : $fileName);

        return $response;
    }

}
