<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $yearOfPublication = null;

    #[ORM\Column(length: 255)]
    private ?string $coverFilename = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getYearOfPublication(): ?int
    {
        return $this->yearOfPublication;
    }

    public function setYearOfPublication(?int $yearOfPublication): self
    {
        $this->yearOfPublication = $yearOfPublication;

        return $this;
    }

    public function getCoverFilename()
    {
        return $this->coverFilename;
    }

    public function setCoverFilename($filename): self
    {
        $this->coverFilename = $filename;

        return $this;
    }
}
