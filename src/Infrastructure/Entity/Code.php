<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Entity\Helper\IDHelper;
use App\Infrastructure\Entity\Helper\TimestampHelper;
use App\Infrastructure\Entity\Helper\UuidHelper;
use App\Infrastructure\Repository\CodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Code
{
    use IDHelper;
    use UuidHelper;
    use TimestampHelper;

    #[ORM\Column(type: 'text')]
    private string $code;

    #[ORM\Column(type: 'integer', name: '`limit`')]
    private int $limit;

    #[ORM\Column(type: 'integer')]
    private int $used;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getUsed(): int
    {
        return $this->used;
    }

    public function setUsed(int $used): void
    {
        $this->used = $used;
    }
}
