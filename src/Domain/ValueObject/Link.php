<?php

namespace App\Domain\ValueObject;

final readonly class Link
{
    private string $link;

    public function __construct(string $link)
    {
        $link = self::addPrefix($link);
        $this->link = $link;
    }

    public static function fromString(string $link): self
    {
        return new self($link);
    }

    public function host(): string
    {
        return parse_url($this->link, PHP_URL_HOST);
    }

    public function scheme(): string
    {
        return parse_url($this->link, PHP_URL_SCHEME);
    }

    public function toString(): string
    {
        return $this->link;
    }

    private static function addPrefix(string $link): string
    {
        if (false !== strpos($link, '@')) {
            throw new \Exception('Incorrect link');
        }
        $urlRegex = "/^(http|https|ftp):\/\/([A-Z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-][A-Z0-9_-ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-]*(?:\.[A-Z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ][A-Z0-9_-ąćęłńóśźżĄĆĘŁŃÓŚŹŻ]*)+):?(\d+)?\/?/i";

        if (false === (bool) preg_match($urlRegex, $link)) {
            $www = 'http://'.$link;
            if (false === (bool) preg_match($urlRegex, $www)) {
                throw new \Exception('Incorrect link');
            }
        } else {
            $www = $link;
        }

        return $www;
    }

    public function equal(Link $link): bool
    {
        return mb_strtolower($link->toString()) === mb_strtolower($this->toString());
    }
}
