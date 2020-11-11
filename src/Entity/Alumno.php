<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlumnoRepository")
 */
class Alumno
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $nExpediente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sexo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Grado", inversedBy="alumnos")
     */
    private $gradoId;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Asignatura", inversedBy="alumnos")
     */
    private $asignaturas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nota", mappedBy="alumnoId")
     */
    private $notas;

    public function __construct()
    {
        $this->asignaturas = new ArrayCollection();
        $this->notas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNExpediente(): ?string
    {
        return $this->nExpediente;
    }

    public function setNExpediente(string $nExpediente): self
    {
        $this->nExpediente = $nExpediente;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getSexo(): ?int
    {
        return $this->sexo;
    }

    public function setSexo(int $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getGradoId(): ?Grado
    {
        return $this->gradoId;
    }

    public function setGradoId(?Grado $gradoId): self
    {
        $this->gradoId = $gradoId;

        return $this;
    }

    /**
     * @return Collection|Asignatura[]
     */
    public function getAsignaturas(): Collection
    {
        return $this->asignaturas;
    }

    public function addAsignatura(Asignatura $asignatura): self
    {
        if (!$this->asignaturas->contains($asignatura)) {
            $this->asignaturas[] = $asignatura;
        }

        return $this;
    }

    public function removeAsignatura(Asignatura $asignatura): self
    {
        if ($this->asignaturas->contains($asignatura)) {
            $this->asignaturas->removeElement($asignatura);
        }

        return $this;
    }

    /**
     * @return Collection|Nota[]
     */
    public function getNotas(): Collection
    {
        return $this->notas;
    }

    public function addNota(Nota $nota): self
    {
        if (!$this->notas->contains($nota)) {
            $this->notas[] = $nota;
            $nota->setAlumnoId($this);
        }

        return $this;
    }

    public function removeNota(Nota $nota): self
    {
        if ($this->notas->contains($nota)) {
            $this->notas->removeElement($nota);
            // set the owning side to null (unless already changed)
            if ($nota->getAlumnoId() === $this) {
                $nota->setAlumnoId(null);
            }
        }

        return $this;
    }
    
    /**
     * Generates the magic method
     * 
     */
    public function __toString(){
        return $this->nombre;
    }
}
