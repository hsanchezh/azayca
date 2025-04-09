<?php

namespace App\Entity;

use App\Repository\TarifaKmRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifaKmRepository::class)]
class TarifaKm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $inicio_vigencia = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fin_vigencia = null;

    #[ORM\Column]
    private ?float $precio_km = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getInicioVigencia(): ?\DateTimeInterface
    {
        return $this->inicio_vigencia;
    }

    public function setInicioVigencia(\DateTimeInterface $inicio_vigencia): static
    {
        $this->inicio_vigencia = $inicio_vigencia;

        return $this;
    }

    public function getFinVigencia(): ?\DateTimeInterface
    {
        return $this->fin_vigencia;
    }

    public function setFinVigencia(?\DateTimeInterface $fin_vigencia): static
    {
        $this->fin_vigencia = $fin_vigencia;

        return $this;
    }

    public function getPrecioKm(): ?float
    {
        return $this->precio_km;
    }

    public function setPrecioKm(float $precio_km): static
    {
        $this->precio_km = $precio_km;

        return $this;
    }

    public function getNombreTarifa(): string{
        if($this->fin_vigencia==null){
            return "Tarifa vigente";
        }
        return $this->inicio_vigencia->format("d/m/Y").' - '.$this->fin_vigencia->format("d/m/Y");
    }
}
