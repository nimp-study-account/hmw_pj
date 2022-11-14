<?php

namespace Nimp\Hmw\Core\Interfaces;

interface ISingleton
{
    public static function getInstance(): self;
}