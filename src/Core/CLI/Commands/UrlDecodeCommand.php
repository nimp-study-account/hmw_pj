<?php

namespace Nimp\Hmw\core\CLI\Commands;
use Nimp\Hmw\Shortener\UrlConvertor;
use UfoCms\ColoredCli\CliColor;

class UrlDecodeCommand extends AbstractCommand
{
    protected UrlConvertor $convertor;

    /**
     * @param UrlConvertor $convertor
     */
    public function __construct(UrlConvertor $convertor)
    {
        $this->convertor = $convertor;
    }

    protected function runAction(): string
    {
        return 'Shortcode: ' . $this->convertor->decode($this->params[0]);
    }

    public static function getCommandDesc(): string
    {
        return 'Decode shortcode to url';
    }

}