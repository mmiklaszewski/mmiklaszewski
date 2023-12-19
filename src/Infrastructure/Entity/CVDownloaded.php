<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Entity\Helper\IDHelper;
use App\Infrastructure\Entity\Helper\TimestampHelper;
use App\Infrastructure\Repository\CVDownloadedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CVDownloadedRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'cv_downloaded')]
class CVDownloaded
{
    use IDHelper;
    use TimestampHelper;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $requestData = [];

    public function getRequestData(): ?array
    {
        return $this->requestData;
    }

    public function setRequestData(?array $requestData): void
    {
        $this->requestData = $requestData;
    }
}
