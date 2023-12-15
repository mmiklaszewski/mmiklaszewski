<?php

namespace App\Domain\ValueObject;

final class DateTime extends \DateTime
{
    public static function now(): self
    {
        $result = new self();
        $result->setTimestamp(time());

        return $result;
    }

    public function toString(): string
    {
        return $this->format('H:i:s d-m-Y');
    }

    public static function fromString(string $datetime): self
    {
        $timestamp = strtotime($datetime);

        // fixing mail problem
        if (false === $timestamp && preg_match('/\+[0-9]+\ ?\(GMT\+[0-9\:]+\)/', $datetime)) {
            $timestamp = strtotime(preg_replace('/\+[0-9]+\ ?\(GMT\+[0-9\:]+\)/', '', $datetime));
        }
        if (false === $timestamp && 'UT' === substr($datetime, -2, 2)) {
            $timestamp = strtotime(substr($datetime, 0, -2).'+0000');
        }
        // fix strange times like 29:14:20
        if (false === $timestamp && preg_match('/[0-9]{2}:[0-9]{2}:[0-9]{2}/', $datetime, $matches)) {
            $strangeTimeParts = explode(':', $matches[0]);
            if ($strangeTimeParts[0] > 24 && $strangeTimeParts[1] > 24) {
                $normalizeTime = implode(':', [$strangeTimeParts[2], $strangeTimeParts[1], $strangeTimeParts[0]]);
            } else {
                $normalizeTime = implode(':', [$strangeTimeParts[1], $strangeTimeParts[2], $strangeTimeParts[0]]);
            }
            $timestamp = strtotime(str_replace($matches[0], $normalizeTime, $datetime));
        }

        $result = new self();
        $result->setTimestamp($timestamp);

        return $result;
    }

    public static function fromDateTime(\DateTime $dateTime): self
    {
        $result = new self();
        $result->setTimestamp($dateTime->getTimestamp());

        return $result;
    }
}
