<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TeachersRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TeachersRepository::class)
 * @ApiResource(
 *      collectionOperations={"get"},
 *      itemOperations={"get"}
 * )
 */
class Teachers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *  @Groups({"school:full:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"school:full:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"school:full:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *  @Groups({"school:full:read"})
     */
    private $mobile;

    /**
     * @ORM\OneToMany(targetEntity=Classes::class, mappedBy="teachers",orphanRemoval=true)
     */
    private $classes;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="teacher", cascade={"persist", "remove"})
     *  @Groups({"school:full:read"})
     * 
     */
    private $user;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
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

    public function getMobile(): ?int
    {
        return $this->mobile;
    }

    public function setMobile(?int $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return Collection|Classes[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classes $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->setTeachers($this);
        }

        return $this;
    }

    public function removeClass(Classes $class): self
    {
        if ($this->classes->contains($class)) {
            $this->classes->removeElement($class);
            // set the owning side to null (unless already changed)
            if ($class->getTeachers() === $this) {
                $class->setTeachers(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newTeacher = null === $user ? null : $this;
        if ($user->getTeacher() !== $newTeacher) {
            $user->setTeacher($newTeacher);
        }

        return $this;
    }
}
