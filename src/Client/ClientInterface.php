<?php

namespace Kematjaya\EscposBundle\Client;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface ClientInterface 
{
    //$this->request->server->get('COMPUTERNAME'); //USERDOMAIN, USERDOMAIN_ROAMINGPROFILE
    
    public function getComputerName():?string;
    
    public function getPrinterName():?string;
    
    public function getConnectionName():?string;
    
    public function getPrinterProfileName():?string;
}
