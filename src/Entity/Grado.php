<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GradoRepository")
 */
class Grado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alumno", mappedBy="gradoId")
     */
    private $alumnos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Asignatura", mappedBy="gradoId")
     */
    private $asignaturas;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->asignaturas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $alumno->setGradoId($this);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): self
    {
        if ($this->alumnos->contains($alumno)) {
            $this->alumnos->removeElement($alumno);
            // set the owning side to null (unless already changed)
            if ($alumno->getGradoId() === $this) {
                $alumno->setGradoId(null);
            }
        }

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
            $asignatura->setGradoId($this);
        }

        return $this;
    }

    public function removeAsignatura(Asignatura $asignatura): self
    {
        if ($this->asignaturas->contains($asignatura)) {
            $this->asignaturas->removeElement($asignatura);
            // set the owning side to null (unless already changed)
            if ($asignatura->getGradoId() === $this) {
                $asignatura->setGradoId(null);
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
