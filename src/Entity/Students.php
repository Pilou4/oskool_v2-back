<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StudentsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StudentsRepository::class)
 */
class Students
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"school:full:read","parent:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"school:full:read","parent:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"school:full:read","parent:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"school:full:read","parent:read"})
     */
    private $birthday;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"school:full:read","parent:read"})
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"school:full:read","parent:read"})
     */
    private $level;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read","parent:read"})
     */
    private $hobbies;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"school:full:read","parent:read"})
     */
    private $health;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"school:full:read","parent:read"})
     */
    private $image_right;

    /**
     * @ORM\ManyToOne(targetEntity=Classes::class, inversedBy="students")
     */
    private $classes;

    /**
     * @ORM\ManyToMany(targetEntity=Parents::class, inversedBy="students")
     */
    private $parents;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getHobbies(): ?string
    {
        return $this->hobbies;
    }

    public function setHobbies(?string $hobbies): self
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    public function getHealth(): ?string
    {
        return $this->health;
    }

    public function setHealth(?string $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getImageRight(): ?string
    {
        return $this->image_right;
    }

    public function setImageRight(?string $image_right): self
    {
        $this->image_right = $image_right;

        return $this;
    }

    public function getClasses(): ?Classes
    {
        return $this->classes;
    }

    public function setClasses(?Classes $classes): self
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * @return Collection|Parents[]
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Parents $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
        }

        return $this;
    }

    public function removeParent(Parents $parent): self
    {
        if ($this->parents->contains($parent)) {
            $this->parents->removeElement($parent);
        }

        return $this;
    }
}
