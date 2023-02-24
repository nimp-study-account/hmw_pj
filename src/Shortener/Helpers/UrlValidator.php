<?php

namespace Nimp\Hmw\Shortener\Helpers;

use InvalidArgumentException;
use Nimp\Hmw\Shortener\Interfaces\IUrlValidator;

class UrlValidator implements \HmwPj\UrlShortener\Interfaces\IUrlValidator
{
    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return bool
     */
    public function baseUrlValidate(string $url): bool
    {
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            throw new InvalidArgumentException('Invalid email');
        }
        return true;
    }

    public function validateUrl(string $url): bool
    {
       return true;
    }

    public function checkRealUrl(string $url): bool
    {
        return true;
    }
}