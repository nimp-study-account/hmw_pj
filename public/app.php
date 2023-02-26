<?php

require_once __DIR__.'/../vendor/autoload.php';


use Nimp\Hmw\Shortener\FileRepository;
use Nimp\Hmw\Shortener\Helpers\UrlValidator;
use Nimp\Hmw\Core\CLI\ConfigHandler;
use HmwPj\UrlShortener\UrlConverter;


$configs = require_once __DIR__ . '/../parameters/configs.php';
$configHandler = ConfigHandler::getInstance()->addConfigs($configs);




$fileRepository = new FileRepository($configHandler->get('dbFile'));
$validator = new UrlValidator();

$converter = new UrlConverter($fileRepository,$validator, $configHandler->get('urlConverter.codeLength'));


if(!empty($_GET['url'])){
    $res = $converter->encode($_GET['url']) . PHP_EOL;
}else{
    $res = 'Приклад передачі GET параметра: http://localhost:8888?url=http://site.com';
}

echo $res;