<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
class Loan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'loans')]
    #[ORM\JoinColumn(name: 'user_id_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null; // L'utilisateur associé à ce prêt

    #[ORM\ManyToOne(inversedBy: 'loans')]
    #[ORM\JoinColumn(name: 'equipment_id_id', referencedColumnName: 'id', nullable: false)]
    private ?Equipment $equipment = null; // L'équipement associé à ce prêt

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_time = null; // Date de début

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_time = null; // Date de fin

    #[ORM\Column]
    private ?bool $status = null; // Statut du prêt (actif ou non)

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null; // Date de création du prêt

    // Getters et setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user; // Retourne l'utilisateur
    }

    public function setUser(?User $user): static
    {
        $this->user = $user; // Définit l'utilisateur
        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment; // Retourne l'équipement
    }

    public function setEquipment(?Equipment $equipment): static
    {
        $this->equipment = $equipment; // Définit l'équipement
        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time; // Retourne la date de début
    }

    public function setStartTime(\DateTimeInterface $start_time): static
    {
        $this->start_time = $start_time; // Définit la date de début
        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time; // Retourne la date de fin
    }

    public function setEndTime(\DateTimeInterface $end_time): static
    {
        $this->end_time = $end_time; // Définit la date de fin
        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status; // Retourne le statut
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status; // Définit le statut
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at; // Retourne la date de création
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at; // Définit la date de création
        return $this;
    }
}
