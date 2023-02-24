<?php

require_once __DIR__.'/../vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Nimp\Hmw\Core\CLI\CLIWriter;
use Nimp\Hmw\Core\CLI\CommandHandler;
use Nimp\Hmw\core\CLI\Commands\UrlDecodeCommand;
use Nimp\Hmw\core\CLI\Commands\UrlEncodeCommand;
use Nimp\Hmw\Core\Helpers\SingletonLogger;
use Nimp\Hmw\Shortener\FileRepository;
use Nimp\Hmw\Shortener\Helpers\UrlValidator;
//use Nimp\Hmw\Shortener\UrlConvertor;
use Nimp\Hmw\Core\CLI\ConfigHandler;
use Nimp\Hmw\core\CLI\Commands\HelpCommand;
use Monolog\Handler\StreamHandler;
use UfoCms\ColoredCli\CliColor;
use HmwPj\UrlShortener\UrlConverter;

$configs = require_once __DIR__ . '/../parameters/configs.php';
$configHandler = ConfigHandler::getInstance()->addConfigs($configs);

$commandHandler = new CommandHandler(new HelpCommand());

$monolog = new Logger($configHandler->get('monolog.channel'));
$monolog->pushHandler(new StreamHandler($configHandler->get('monolog.level.error'), Level::Error))
    ->pushHandler(new StreamHandler($configHandler->get('monolog.level.info'), Level::Info));

$singletonLogger = SingletonLogger::getInstance($monolog);


$fileRepository = new FileRepository($configHandler->get('dbFile'));
$validator = new UrlValidator();

$converter = new UrlConverter($fileRepository,$validator, $configHandler->get('urlConverter.codeLength'));

 echo $res = $converter->encode('http://site.com') . PHP_EOL;

 die();

$commandHandler->addCommand(new UrlEncodeCommand($converter));
$commandHandler->addCommand(new UrlDecodeCommand($converter));

$commandHandler->handle($argv, function ($params, \Throwable $e) {
    SingletonLogger::error($e->getMessage());
    CLIWriter::getInstance()->setColor(CliColor::RED)
        ->writeLn($e->getMessage());

    CLIWriter::getInstance()->write($e->getFile() . ': ')
        ->writeLn($e->getLine());
});
