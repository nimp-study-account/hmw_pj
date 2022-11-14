<?php

namespace Nimp\Hmw\Shortener\Helpers;

use InvalidArgumentException;
use Nimp\Hmw\Shortener\Interfaces\IUrlValidator;

class UrlValidator implements IUrlValidator
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
}