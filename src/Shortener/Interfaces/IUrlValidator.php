<?php

namespace Nimp\Hmw\Shortener\Interfaces;

use InvalidArgumentException;

interface IUrlValidator
{
    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return bool
     */
    public function baseUrlValidate(string $url): bool;
}