<?php

namespace Nimp\Hmw\Shortener;

use InvalidArgumentException;
use Nimp\Hmw\Core\Helpers\SingletonLogger;
use Nimp\Hmw\Shortener\Exceptions\DataNotFoundException;
use Nimp\Hmw\Shortener\Interfaces\ICodeRepository;
use Nimp\Hmw\Shortener\Interfaces\IUrlDecoder;
use Nimp\Hmw\Shortener\Interfaces\IUrlEncoder;
use Nimp\Hmw\Shortener\Interfaces\IUrlValidator;
use Nimp\Hmw\Shortener\ValueObjects\UrlCodePair;

class UrlConvertor implements IUrlDecoder, IUrlEncoder
{
    public IUrlValidator $urlValidator;
    public ICodeRepository $repository;
    const CODE_CHAIRS = 'qwe123qwe';
    public int $length = 8;

    public function __construct(
        IUrlValidator $UrlValidator,
        ICodeRepository $repository,
        ? int $codeLength,
    )
    {
        $this->repository = $repository;
        $this->urlValidator = $UrlValidator;
        $this->length = $codeLength;
    }

    /**
     * @param string $code
     * @throws InvalidArgumentException
     * @return string
     */
    public function decode(string $code): string
    {
        try {
            $code = $this->repository->getUrlByCode($code);
        } catch (DataNotFoundException $e) {
            SingletonLogger::error($e->getMessage());
            throw new InvalidArgumentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
        return $code;
    }

    public function encode(string $url): string
    {
        $this->validate($url);

        try {
            $code = $this->repository->getCodeByUrl($url);
        }catch (DataNotFoundException $e){
            $code = $this->generateAndSaveCode($url);
        }

        return  $code;
    }

    protected function validate(string $url) : bool
    {
        try {
            $result = $this->urlValidator->baseUrlValidate($url);
        }catch (InvalidArgumentException $e){
            SingletonLogger::error($e->getMessage());
            throw $e;
        }
        return $result;
    }

    protected function generateAndSaveCode(string $url): string
    {
        $code = $this->generateUniqueCode();
        $this->repository->saveEntity(new UrlCodePair($code, $url));
        return $code;
    }

    protected function generateUniqueCode(): string
    {
        $date = new \DateTime();
        $str = static::CODE_CHAIRS . mb_strtoupper(static::CODE_CHAIRS) . $date->getTimestamp();
        return substr(str_shuffle($str), 0, $this->length);
    }

}