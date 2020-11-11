<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AsignaturaRepository")
 */
class Asignatura
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
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreIngles;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $credects;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Alumno", mappedBy="asignaturas")
     */
    private $alumnos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nota", mappedBy="asignaturaId")
     */
    private $notas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Grado", inversedBy="asignaturas")
     */
    private $gradoId;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->notas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

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

    public function getNombreIngles(): ?string
    {
        return $this->nombreIngles;
    }

    public function setNombreIngles(string $nombreIngles): self
    {
        $this->nombreIngles = $nombreIngles;

        return $this;
    }

    public function getCredects(): ?string
    {
        return $this->credects;
    }

    public function setCredects(?string $credects): self
    {
        $this->credects = $credects;

        return $this;
    }

    /**
     * @return Collection|Alumno[]
     */
    public function getAlumnos(): Collection
    {
        return $this->alumnos;
    }

    public function addAlumno(Alumno $alumno): self
    {
        if (!$this->alumnos->contains($alumno)) {
            $this->alumnos[] = $alumno;
            $alumno->addAsignatura($this);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): self
    {
        if ($this->alumnos->contains($alumno)) {
            $this->alumnos->removeElement($alumno);
            $alumno->removeAsignatura($this);
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
            $nota->setAsignaturaId($this);
        }

        return $this;
    }

    public function removeNota(Nota $nota): self
    {
        if ($this->notas->contains($nota)) {
            $this->notas->removeElement($nota);
            // set the owning side to null (unless already changed)
            if ($nota->getAsignaturaId() === $this) {
                $nota->setAsignaturaId(null);
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

    public function getGradoId(): ?Grado
    {
        return $this->gradoId;
    }

    public function setGradoId(?Grado $gradoId): self
    {
        $this->gradoId = $gradoId;

        return $this;
    }
}
