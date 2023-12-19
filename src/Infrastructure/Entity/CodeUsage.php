<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Doctrine\Type\UuidType;
use App\Infrastructure\Entity\Helper\IDHelper;
use App\Infrastructure\Entity\Helper\TimestampHelper;
use App\Infrastructure\Entity\Helper\UuidHelper;
use App\Infrastructure\Repository\CodeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CodeRepository::class)]
#[ORM\HasLifecycleCallbacks]
final class CodeUsage
{
    use IDHelper;
    use UuidHelper;
    use TimestampHelper;

    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $code;

    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $movie;

    public function getCode(): Uuid
    {
        return $this->code;
    }

    public function setCode(Uuid $code): void
    {
        $this->code = $code;
    }

    public function getMovie(): Uuid
    {
        return $this->movie;
    }

    public function setMovie(Uuid $movie): void
    {
        $this->movie = $movie;
    }
}
