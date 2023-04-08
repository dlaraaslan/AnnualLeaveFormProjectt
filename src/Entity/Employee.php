<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $surname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDateOfWork = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfDismissal = null;

    #[ORM\Column(length: 7)]
    private ?string $registerNo = null;

    #[ORM\Column(length: 11)]
    private ?string $indentityNumber = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getStartDateOfWork(): ?\DateTimeInterface
    {
        return $this->startDateOfWork;
    }

    public function setStartDateOfWork(\DateTimeInterface $startDateOfWork): self
    {
        $this->startDateOfWork = $startDateOfWork;

        return $this;
    }

    public function getDateOfDismissal(): ?\DateTimeInterface
    {
        return $this->dateOfDismissal;
    }

    public function setDateOfDismissal(?\DateTimeInterface $dateOfDismissal): self
    {
        $this->dateOfDismissal = $dateOfDismissal;

        return $this;
    }

    public function getRegisterNo(): ?string
    {
        return $this->registerNo;
    }

    public function setRegisterNo(string $registerNo): self
    {
        $this->registerNo = $registerNo;

        return $this;
    }

    public function getIndentityNumber(): ?string
    {
        return $this->indentityNumber;
    }

    public function setIndentityNumber(string $indentityNumber): self
    {
        $this->indentityNumber = $indentityNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
