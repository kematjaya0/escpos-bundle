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
    
    /**
     * 
     * @var string|null
     */
    private $connectionName;
    
    /**
     * 
     * @var string|null
     */
    private $printerProfileName;
    
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
    
    /**
     * Connection name, default smb://guest@{computer}/{printer}
     * 
     * @return string|null
     */
    public function getConnectionName(): ?string
    {
        return null !== $this->connectionName ? $this->connectionName : parent::getConnectionName();
    }
    
    /**
     * Set connection name, mis. "tcp://192.168.1.10:9100", "cups://POS-58", "file:///dev/usb/lp0"
     * 
     * @param  string|null $connectionName
     * @return self
     */
    public function setConnectionName(?string $connectionName): self
    {
        $this->connectionName = $connectionName;
        
        return $this;
    }
    
    /**
     * Printer capability profile, default POS-5890
     * 
     * @return string|null
     */
    public function getPrinterProfileName(): ?string
    {
        return null !== $this->printerProfileName ? $this->printerProfileName : parent::getPrinterProfileName();
    }
    
    public function setPrinterProfileName(?string $printerProfileName): self
    {
        $this->printerProfileName = $printerProfileName;
        
        return $this;
    }
}
