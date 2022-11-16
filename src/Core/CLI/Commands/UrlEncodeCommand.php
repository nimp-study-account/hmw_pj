<?php

namespace Nimp\Hmw\core\CLI\Commands;
use Nimp\Hmw\Shortener\UrlConvertor;
use UfoCms\ColoredCli\CliColor;

class UrlEncodeCommand extends AbstractCommand
{
    protected UrlConvertor $convertor;

    /**
     * @param UrlConvertor $convertor
     */
    public function __construct(UrlConvertor $convertor)
    {
        $this->convertor = $convertor;
    }

    /**
     * @inheritDoc
     */
    protected function runAction(): string
    {
        return 'Shortcode: ' . $this->convertor->encode($this->params[0] ?? '');
    }

    /**
     * @inheritDoc
     */
    public static function getCommandDesc(): string
    {
        return 'Encode the url to sort code';
    }

}