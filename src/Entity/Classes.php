<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ClassesRepository::class)
 */
class Classes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255 )
     */
    private $level;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $agenda;

    /**
     * @ORM\ManyToOne(targetEntity=Schools::class, inversedBy="classes")
     */
    private $schools;

    /**
     * @ORM\ManyToOne(targetEntity=Teachers::class, inversedBy="classes")
     */
    private $teachers;

    /**
     * @ORM\OneToMany(targetEntity=Students::class, mappedBy="classes",orphanRemoval=true)
     */
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getAgenda(): ?string
    {
        return $this->agenda;
    }

    public function setAgenda(?string $agenda): self
    {
        $this->agenda = $agenda;

        return $this;
    }

    public function getSchools(): ?Schools
    {
        return $this->schools;
    }

    public function setSchools(?Schools $schools): self
    {
        $this->schools = $schools;

        return $this;
    }

    public function getTeachers(): ?Teachers
    {
        return $this->teachers;
    }

    public function setTeachers(?Teachers $teachers): self
    {
        $this->teachers = $teachers;

        return $this;
    }

    /**
     * @return Collection|Students[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Students $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setClasses($this);
        }

        return $this;
    }

    public function removeStudent(Students $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            // set the owning side to null (unless already changed)
            if ($student->getClasses() === $this) {
                $student->setClasses(null);
            }
        }

        return $this;
    }
}
