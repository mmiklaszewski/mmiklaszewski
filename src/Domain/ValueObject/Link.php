<?php

namespace App\Domain\ValueObject;

final readonly class Link
{
    private string $domain;

    public function __construct(string $domain)
    {
        $domain = self::addPrefix($domain);
        $this->domain = strtolower($domain);
    }

    public static function fromString(string $domain): self
    {
        return new self($domain);
    }

    public function host(): string
    {
        return parse_url($this->domain, PHP_URL_HOST);
    }

    public function toString(): string
    {
        return $this->domain;
    }

    private static function addPrefix(string $domain): string
    {
        if (false !== strpos($domain, '@')) {
            throw new \Exception('Incorrect domain');
        }
        $urlRegex = "/^(http|https|ftp):\/\/([A-Z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-][A-Z0-9_-ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-]*(?:\.[A-Z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ][A-Z0-9_-ąćęłńóśźżĄĆĘŁŃÓŚŹŻ]*)+):?(\d+)?\/?/i";

        if (false === (bool) preg_match($urlRegex, $domain)) {
            $www = 'http://'.$domain;
            if (false === (bool) preg_match($urlRegex, $www)) {
                throw new \Exception('Incorrect domain');
            }
        } else {
            $www = $domain;
        }

        return $www;
    }

    public function equal(Link $domain): bool
    {
        return $domain->toString() === $this->toString();
    }
}
