<?php

namespace App\Entity;

use App\Repository\ViajeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ViajeRepository::class)]
class Viaje
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?bool $es_ida_vuelta = null;

    #[ORM\Column(enumType: Valoracion::class)]
    private ?Valoracion $valoracion = null;

    #[ORM\Column(length: 600, nullable: true)]
    private ?string $comentarios = null;

    #[ORM\ManyToOne(inversedBy: 'viajes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paciente $id_paciente = null;

    #[ORM\ManyToOne(inversedBy: 'viajes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Conductor $id_conductor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TarifaKm $id_tarifa_km = null;

    #[ORM\ManyToOne]
    private ?TarifaEspera $id_tarifa_espera = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localidad $id_localidad = null;

    #[ORM\Column]
    private ?float $num_kilometros = null;

    #[ORM\Column]
    private ?float $importe_distancia = null;

    #[ORM\Column(nullable: true)]
    private ?float $horas_espera = null;

    #[ORM\Column(nullable: true)]
    private ?float $importe_espera = null;

    #[ORM\Column]
    private ?float $importe_total = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function isEsIdaVuelta(): ?bool
    {
        return $this->es_ida_vuelta;
    }

    public function setEsIdaVuelta(bool $es_ida_vuelta): static
    {
        $this->es_ida_vuelta = $es_ida_vuelta;

        return $this;
    }

    public function getValoracion(): ?Valoracion
    {
        return $this->valoracion;
    }

    public function setValoracion(Valoracion $valoracion): static
    {
        $this->valoracion = $valoracion;

        return $this;
    }

    public function getComentarios(): ?string
    {
        return $this->comentarios;
    }

    public function setComentarios(?string $comentarios): static
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    public function getIdPaciente(): ?Paciente
    {
        return $this->id_paciente;
    }

    public function setIdPaciente(?Paciente $id_paciente): static
    {
        $this->id_paciente = $id_paciente;

        return $this;
    }

    public function getIdConductor(): ?Conductor
    {
        return $this->id_conductor;
    }

    public function setIdConductor(?Conductor $id_conductor): static
    {
        $this->id_conductor = $id_conductor;

        return $this;
    }

    public function getIdTarifaKm(): ?TarifaKm
    {
        return $this->id_tarifa_km;
    }

    public function setIdTarifaKm(?TarifaKm $id_tarifa_km): static
    {
        $this->id_tarifa_km = $id_tarifa_km;

        return $this;
    }

    public function getIdTarifaEspera(): ?TarifaEspera
    {
        return $this->id_tarifa_espera;
    }

    public function setIdTarifaEspera(?TarifaEspera $id_tarifa_espera): static
    {
        $this->id_tarifa_espera = $id_tarifa_espera;

        return $this;
    }

    public function getIdLocalidad(): ?Localidad
    {
        return $this->id_localidad;
    }

    public function setIdLocalidad(?Localidad $id_localidad): static
    {
        $this->id_localidad = $id_localidad;

        return $this;
    }

    public function getNumKilometros(): ?float
    {
        return $this->num_kilometros;
    }

    public function setNumKilometros(float $num_kilometros): static
    {
        $this->num_kilometros = $num_kilometros;

        return $this;
    }

    public function getImporteDistancia(): ?float
    {
        return $this->importe_distancia;
    }

    public function setImporteDistancia(float $importe_distancia): static
    {
        $this->importe_distancia = $importe_distancia;

        return $this;
    }

    public function getHorasEspera(): ?float
    {
        return $this->horas_espera;
    }

    public function setHorasEspera(?float $horas_espera): static
    {
        $this->horas_espera = $horas_espera;

        return $this;
    }

    public function getImporteEspera(): ?float
    {
        return $this->importe_espera;
    }

    public function setImporteEspera(?float $importe_espera): static
    {
        $this->importe_espera = $importe_espera;

        return $this;
    }

    public function getImporteTotal(): ?float
    {
        return $this->importe_total;
    }

    public function setImporteTotal(float $importe_total): static
    {
        $this->importe_total = $importe_total;

        return $this;
    }
}
