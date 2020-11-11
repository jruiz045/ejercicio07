<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotaRepository")
 */
class Nota
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
    private $nConvocatoria;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="float")
     */
    private $nota;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Alumno", inversedBy="notas")
     */
    private $alumnoId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Asignatura", inversedBy="notas")
     */
    private $asignaturaId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNConvocatoria(): ?string
    {
        return $this->nConvocatoria;
    }

    public function setNConvocatoria(string $nConvocatoria): self
    {
        $this->nConvocatoria = $nConvocatoria;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getNota(): ?float
    {
        return $this->nota;
    }

    public function setNota(float $nota): self
    {
        $this->nota = $nota;

        return $this;
    }

    public function getAlumnoId(): ?Alumno
    {
        return $this->alumnoId;
    }

    public function setAlumnoId(?Alumno $alumnoId): self
    {
        $this->alumnoId = $alumnoId;

        return $this;
    }

    public function getAsignaturaId(): ?Asignatura
    {
        return $this->asignaturaId;
    }

    public function setAsignaturaId(?Asignatura $asignaturaId): self
    {
        $this->asignaturaId = $asignaturaId;

        return $this;
    }
}
