<?php

/**
 * This file is part of the esc-pos-bundle.
 */

namespace Kematjaya\EscposBundle\Client;

/**
 * @package Kematjaya\EscposBundle\Client
 * @license https://opensource.org/licenses/MIT MIT
 * @author  Nur Hidayatullah <kematjaya0@gmail.com>
 */
class DefaultClient extends AbstractWindowsClient
{
    /**
     * 
     * @var string
     */
    private $computerName;
    
    /**
     * 
     * @var string
     */
    private $printerName;
    
    public function getComputerName(): ?string 
    {
        return $this->computerName;
    }

    public function getPrinterName(): ?string 
    {
        return $this->printerName;
    }

    public function setComputerName(string $computerName): self 
    {
        $this->computerName = $computerName;
        
        return $this;
    }

    public function setPrinterName(string $printerName): self 
    {
        $this->printerName = $printerName;
        
        return $this;
    }


}
