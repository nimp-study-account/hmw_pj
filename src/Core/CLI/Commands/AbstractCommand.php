<?php

namespace Nimp\Hmw\core\CLI\Commands;

use Nimp\Hmw\Core\CLI\CLIWriter;
use Nimp\Hmw\Core\CLI\Helpers\CliParamAnalyzer;
use Nimp\Hmw\Core\CLI\Interfaces\ICliCommand;
use Nimp\Hmw\Core\Interfaces\IWriter;
use UfoCms\ColoredCli\CliColor;

abstract class AbstractCommand implements ICliCommand
{
    const NAME = 'undefined';

    protected array $params = [];

    protected IWriter $writer;

    /**
     * @inheritDoc
     */
    public static function getCommandName(): string
    {
        $name = static::NAME;
        if (static::NAME === self::NAME) {
            $path = explode('\\', static::class);
            $classCommandName = str_replace('Command', '', array_pop($path));
            $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $classCommandName));
        }
        return $name;
    }

    /**
     * @inheritDoc
     */
    public static function getCommandDesc(): string
    {
        return '';
    }

    protected function printVerboseInfo(): void
    {
        $this->writer = CLIWriter::getInstance();
        if (CliParamAnalyzer::isVerbose()) {
            $this->writer->setColor(CliColor::YELLOW)->writeBorder()
                ->writeLn(static::getCommandName())
                ->writeLn(static::getCommandDesc())
                ->writeBorder();
        }
    }

    /**
     * @return string
     */
    abstract protected function runAction(): string;

    /**
     * @inheritDoc
     */
    public function run(array $params = []): void
    {
        $this->params = $params;
        $this->printVerboseInfo();
        $this->writer->setColor(CliColor::CYAN);
        $this->writer->writeLn($this->runAction());
    }
}