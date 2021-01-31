<?php

namespace Kematjaya\EscposBundle\Client;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
abstract class AbstractWindowsClient implements ClientInterface 
{
    public function getConnectionName():?string
    {
        return sprintf('smb://guest@%s/%s', $this->getComputerName(), $this->getPrinterName());
    }
    
    public function getPrinterProfileName():?string
    {
        return 'POS-5890';
    }
}
