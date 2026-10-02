<?php

namespace Kematjaya\EscposBundle\Formatter;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class TextFormatter implements FormatterInterface
{
    private ?string $header = null;
    private ?string $content = null;

    public function addText(string $text): FormatterInterface
    {
        $this->content .= $text;

        return $this;
    }

    public function addEnter(): static
    {
        $this->content .= PHP_EOL;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->content;
    }

    public function clear(): static
    {
        $this->content = null;

        return $this;
    }

    public function setHeader(string $header): FormatterInterface
    {
        $this->header = $header;

        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setText(string $text): FormatterInterface
    {
        $this->content = $text;

        return $this;
    }

}
