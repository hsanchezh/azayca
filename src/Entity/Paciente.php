<?php

namespace App\Entity;

use App\Repository\PacienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PacienteRepository::class)]
class Paciente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $nombre = null;

    #[ORM\Column(length: 40)]
    private ?string $apellido1 = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $apellido2 = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $telefono = null;

    #[ORM\Column(nullable: true)]
    private ?int $telefono2 = null;

    #[ORM\Column(length: 12)]
    private ?string $dni = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localidad $id_localidad = null;

    #[ORM\Column]
    private ?bool $es_socio = null;

    #[ORM\Column(length: 10)]
    private ?string $codigo = null;

    /**
     * @var Collection<int, Viaje>
     */
    #[ORM\OneToMany(targetEntity: Viaje::class, mappedBy: 'id_paciente')]
    private Collection $viajes;

    public function __construct()
    {
        $this->viajes = new ArrayCollection();
    }

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

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): static
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(?string $apellido2): static
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getTelefono2(): ?int
    {
        return $this->telefono2;
    }

    public function setTelefono2(?int $telefono2): static
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

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

    public function isEsSocio(): ?bool
    {
        return $this->es_socio;
    }

    public function setEsSocio(bool $es_socio): static
    {
        $this->es_socio = $es_socio;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): static
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * @return Collection<int, Viaje>
     */
    public function getViajes(): Collection
    {
        return $this->viajes;
    }

    public function addViaje(Viaje $viaje): static
    {
        if (!$this->viajes->contains($viaje)) {
            $this->viajes->add($viaje);
            $viaje->setIdPaciente($this);
        }

        return $this;
    }

    public function removeViaje(Viaje $viaje): static
    {
        if ($this->viajes->removeElement($viaje)) {
            // set the owning side to null (unless already changed)
            if ($viaje->getIdPaciente() === $this) {
                $viaje->setIdPaciente(null);
            }
        }

        return $this;
    }
}
