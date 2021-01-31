<?php

namespace Kematjaya\EscposBundle\Formatter;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface FormatterInterface 
{
    public function setText(string $text):self;
    
    public function addText(string $text):self;
    
    public function addEnter();
    
    public function getText():?string;
    
    public function clear();
    
    public function setHeader(string $header):self;
    
    public function getHeader():?string;
}
