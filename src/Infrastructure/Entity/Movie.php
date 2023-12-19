<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Entity\Helper\IDHelper;
use App\Infrastructure\Entity\Helper\TimestampHelper;
use App\Infrastructure\Entity\Helper\UuidHelper;
use App\Infrastructure\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Movie
{
    use IDHelper;
    use UuidHelper;
    use TimestampHelper;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $detailsLink = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $details = [];

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $descriptionsLink = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $descriptions = [];

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $review = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $preferences = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $posterLink = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $whereWatch = null;

    // todo who (by code). where to watch

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function getDetailsLink(): ?string
    {
        return $this->detailsLink;
    }

    public function setDetailsLink(?string $detailsLink): void
    {
        $this->detailsLink = $detailsLink;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }

    public function setDetails(?array $details): void
    {
        $this->details = $details;
    }

    public function getDescriptionsLink(): ?string
    {
        return $this->descriptionsLink;
    }

    public function setDescriptionsLink(?string $descriptionsLink): void
    {
        $this->descriptionsLink = $descriptionsLink;
    }

    public function getDescriptions(): ?array
    {
        return $this->descriptions;
    }

    public function setDescriptions(?array $descriptions): void
    {
        $this->descriptions = $descriptions;
    }

    public function getReview(): ?array
    {
        return $this->review;
    }

    public function setReview(?array $review): void
    {
        $this->review = $review;
    }

    public function getPreferences(): ?string
    {
        return $this->preferences;
    }

    public function setPreferences(?string $preferences): void
    {
        $this->preferences = $preferences;
    }

    public function getPosterLink(): ?string
    {
        return $this->posterLink;
    }

    public function setPosterLink(?string $posterLink): void
    {
        $this->posterLink = $posterLink;
    }

    public function getWhereWatch(): ?array
    {
        return $this->whereWatch;
    }

    public function setWhereWatch(?array $whereWatch): void
    {
        $this->whereWatch = $whereWatch;
    }
}
