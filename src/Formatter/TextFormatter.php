<?php

namespace Kematjaya\EscposBundle\Formatter;

use Kematjaya\EscposBundle\Formatter\FormatterInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class TextFormatter implements FormatterInterface
{
     private $header, $content;
    
    public function addText(string $text):FormatterInterface
    {
        $this->content .= $text;
        
        return $this;
    }
    
    public function addEnter()
    {
        $this->content .= "\n";
        
        return $this;
    }
    
    public function getText():?string
    {
        return $this->content;
    }
    
    public function clear()
    {
        $this->content = null;
    }
    
    public function setHeader(string $header):FormatterInterface
    {
        $this->header = $header;
        
        return $this;
    }
    
    public function getHeader():?string
    {
        return $this->header;
    }

    public function setText(string $text): FormatterInterface 
    {
        $this->content = $text;
        
        return $this;
    }

}
