<?php

namespace App\Infrastructure\Entity\Helper;

use App\Infrastructure\Doctrine\Type\UuidType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

trait UuidHelper
{
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $uuid = null;

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function setUuid(?Uuid $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function generateUuid(): void
    {
        $this->uuid = Uuid::v4();
    }
}
