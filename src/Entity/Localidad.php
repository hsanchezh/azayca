<?php

namespace App\Entity;

use App\Repository\LocalidadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalidadRepository::class)]
class Localidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $nombre = null;

    private ?int $totalViajes=0;
    private ?int $totalPacientes=0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getTotalViajes(): ?int
    {
        return $this->totalViajes;
    }

    public function setTotalViajes(?int $totalViajes): void
    {
        $this->totalViajes = $totalViajes;
    }

    public function getTotalPacientes(): ?int
    {
        return $this->totalPacientes;
    }

    public function setTotalPacientes(?int $totalPacientes): void
    {
        $this->totalPacientes = $totalPacientes;
    }
}
