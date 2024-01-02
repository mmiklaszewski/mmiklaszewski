<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Doctrine\Type\UuidType;
use App\Infrastructure\Entity\Helper\IDHelper;
use App\Infrastructure\Entity\Helper\TimestampHelper;
use App\Infrastructure\Entity\Helper\UuidHelper;
use App\Infrastructure\Repository\OpinionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OpinionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Opinion
{
    use IDHelper;
    use UuidHelper;
    use TimestampHelper;

    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $movie;

    #[ORM\Column(type: 'text')]
    private string $opinion;

    public function getMovie(): Uuid
    {
        return $this->movie;
    }

    public function setMovie(Uuid $movie): void
    {
        $this->movie = $movie;
    }

    public function getOpinion(): string
    {
        return $this->opinion;
    }

    public function setOpinion(string $opinion): void
    {
        $this->opinion = $opinion;
    }
}
