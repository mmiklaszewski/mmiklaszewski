<?php

namespace App\Infrastructure\Entity;

use App\Domain\ValueObject\DateTime as DateTimeVO;
use App\Infrastructure\Doctrine\Type\UuidType;
use App\Infrastructure\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $uuid = null;
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

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTime $updatedAt = null;

    // todo who (by code). where to watch

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function setUuid(?Uuid $uuid): void
    {
        $this->uuid = $uuid;
    }

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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = DateTimeVO::now();
        $this->updatedAt = DateTimeVO::now();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = DateTimeVO::now();
    }
}
